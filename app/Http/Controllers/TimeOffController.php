<?php

namespace App\Http\Controllers;

use App\Http\Requests\TimeOffStoreRequest;
use App\Models\Employee;
use App\Models\TimeOff;
use App\Notifications\TimeOffApproved;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class TimeOffController extends Controller
{

    public function __construct()
    {
        $this->authorizeResource(TimeOff::class, 'timeOff', ['except' => 'update']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('time_offs.index')->with([
            'timeOffs' => Auth::user()->employee->timeOffs()->orderByDesc('created_at')->paginate(10),
            'types' => TimeOff::$types
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param TimeOffStoreRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(TimeOffStoreRequest $request)
    {
        $employee      = Auth::user()->employee;
        $paidTime      = $employee->paid_time;
        $isExpired     = $employee->vacation_expire ? Carbon::parse($employee->vacation_expire)->isAfter(Carbon::now()) : false;
        $request->paid = !(($paidTime <= 0 || $isExpired) && $request->paid == true);
        $timeOff       = $employee->timeOffs()->create($request->all());
        if ($timeOff->paid) {
            $employee->paid_time -= $timeOff->duration;
        } else {
            $employee->unpaid_time += $timeOff->duration;
        }
        if ($employee->paid_time < 0) {
            $employee->unpaid_time += abs($employee->paid_time);
            $employee->paid_time   = 0;
        }
        $employee->save();

        return back();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function manage()
    {
        $this->authorize('manage', 'App\Models\TimeOff');

        return view('time_offs.manage')->with([
            'expireDate' => Employee::first()->vacation_expire,
            'timeOffs'   => TimeOff::with('employee')->orderByDesc('created_at')->paginate(15),
            'types'      => TimeOff::$types
        ]);
    }

    /**
     * Approve the time-off
     *
     * @param TimeOff $timeOff
     *
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function approve(TimeOff $timeOff)
    {
        $this->authorize('approve', $timeOff);

        $timeOff->approved = true;
        $timeOff->save();
        $timeOff->employee->user->notify(new TimeOffApproved($timeOff));

        return back();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(Request $request)
    {
        $this->authorize('update', 'App\Models\TimeOff');
        $date      = Carbon::parse($request->expire_date);
        $employees = Employee::all();
        foreach ($employees as $e) {
            $e->vacation_expire = $date;
            $e->save();
        }

        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\TimeOff $timeOff
     *
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy(TimeOff $timeOff)
    {
        $employee = $timeOff->employee;
        if ($timeOff->paid) {
            $employee->paid_time += $timeOff->duration;
        } else {
            $employee->unpaid_time -= $timeOff->duration;
        }
        if ($employee->unpaid_time < 0) {
            $employee->paid_time   += abs($employee->unpaid_time);
            $employee->unpaid_time = 0;
        }
        $employee->save();
        $timeOff->delete();

        return back();
    }
}
