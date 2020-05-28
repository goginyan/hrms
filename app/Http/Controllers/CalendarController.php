<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class CalendarController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        return view('calendar.index')->with([
            'employee' => Auth::user()->employee
        ]);
    }

    /**
     * Calendar settings update
     *
     * @param Employee $employee
     * @param Request  $request
     *
     * @return RedirectResponse
     */
    public function update(Employee $employee, Request $request)
    {
        $employee->calendarSettings->updateOrCreate(
            ['employee_id' => $employee->id],
            [
                'assigned_tasks_color' => $request->assigned_tasks_color,
                'created_tasks_color'  => $request->created_tasks_color,
            ]
        );

        return back();
    }
}
