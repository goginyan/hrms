<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Reward;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RewardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $user     = Auth::user();
        $employee = $user->employee;
        if ($user->can('manage rewards')) {
            $rewards = Reward::with(['recognizer', 'rewarded'])->orderBy('is_approved')->get();
        } else {
            $rewards = Reward::where('is_approved', true)
                             ->with(['recognizer', 'rewarded'])
                             ->orderBy('created_at', 'desc')
                             ->get();
        }

        return view('rewards.feed')->with([
            'rewards'        => $rewards,
            'receivedPoints' => $employee->reward_received,
            'leftPoints'     => $employee->reward_left,
            'employees'      => Employee::all()->toJson()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Reward $reward
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Reward $reward)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Reward $reward
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Reward $reward)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Reward       $reward
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Reward $reward)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Reward $reward
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Reward $reward)
    {
        //
    }
}
