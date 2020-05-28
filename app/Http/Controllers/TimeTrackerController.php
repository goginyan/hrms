<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\TimeTracker;
use Carbon\Carbon;
use foo\bar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Date;

class TimeTrackerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('tracker.index')->with([
            'trackers' => Auth::user()->employee->trackers()->whereBetween('created_at', [
                today(),
                Date::tomorrow()
            ])->with('task')->get(),
            'tasks'    => Auth::user()->employee->allAssignedTasks,
        ]);
    }

    /**
     * Display the timesheet of the employee
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function timesheet()
    {
        $from      = request('from') ? request('from') : today();
        $to        = request('to') ? request('to') : Date::tomorrow();
        $days      = [];
        $durations = [];
        $items     = Auth::user()->employee->trackers()->whereBetween('created_at', [
            $from,
            $to
        ])->orderBy('created_at')->with('task')->get();
        foreach ($items as $item) {
            $days[$item->created_at->format('jS \of\ F, Y')][] = $item;
            if (isset($durations[$item->created_at->format('jS \of\ F, Y')])) {
                $durations[$item->created_at->format('jS \of\ F, Y')] += $item->duration;
            } else {
                $durations[$item->created_at->format('jS \of\ F, Y')] = $item->duration;
            }
        }
        foreach ($durations as &$day) {
            $minutes = $day % 60;
            $hours   = ($day - $minutes) / 60;
            $day     = ($hours > 0 ? "$hours " . __('hours') . " " : "") . "$minutes " . __('minutes');
        }

        return view('tracker.timesheet')->with([
            'days'      => $days,
            'durations' => $durations,
            'tasks'     => Auth::user()->employee->allAssignedTasks,
            'from'      => $from,
            'to'        => request('to')
        ]);
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
        if ($request->ajax()) {
            $tracker = Auth::user()->employee->trackers()->create($request->all());
            if ($request->task_id) {
                $task = Task::find($request->task_id);
                $tracker->task()->associate($task);

                if ($task->status == 'new' || $task->status == 'confirmed') {
                    $task->started_at = now();
                }
                $task->status = 'in_process';
                $task->save();
                $tracker->save();
            }

            return response()->json([
                'tracker' => $tracker->jsonSerialize(),
                'task' => isset($task) ? $task->jsonSerialize() : ''
            ]);
        }
        $timeTracker = Auth::user()->employee->trackers()->create([]);
        if ($request->has('task_id') && $request->task_id > 0) {
            $timeTracker->task()->dissociate();
            $timeTracker->task()->associate(Task::findOrFail($request->task_id));
        }
        if ($request->has('created_at')) {
            $timeTracker->created_at = $request->created_at;
        }
        if ($request->has('comment')) {
            $timeTracker->comment = $request->comment;
        }
        if ($request->has('duration') && $request->duration > 0) {
            $timeTracker->duration    = $request->duration;
            $timeTracker->finished_at = Carbon::createFromFormat('U', (int)$timeTracker->created_at->format('U') + $request->duration * 60);
            if ($timeTracker->task) {
                $timeTracker->task->duration += (int)$request->duration;
                $timeTracker->task->save();
            }
        }
        $timeTracker->save();

        return back();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\TimeTracker  $timeTracker
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TimeTracker $timeTracker)
    {
        if ($request->ajax()) {
            if ($request->has('finished_at')) {
                $timeTracker->finished_at = now();
                $timeTracker->duration    = ceil(($timeTracker->finished_at->format('U') - $timeTracker->created_at->format('U')) / 60);
                if ($timeTracker->task) {
                    $timeTracker->task->duration += $timeTracker->duration;
                    $timeTracker->task->save();
                }
                $timeTracker->save();

                return response()->json([], 204);
            }

            return response()->json([], 400);
        }
        if ($request->has('task_id')) {
            $timeTracker->task()->dissociate();
            $timeTracker->task()->associate(Task::findOrFail($request->task_id));
        }
        if ($request->has('comment')) {
            $timeTracker->comment = $request->comment;
        }
        if ($request->has('duration') && $request->duration > 0) {
            $timeTracker->duration    = $request->duration;
            $timeTracker->finished_at = Carbon::createFromFormat('U', (int)$timeTracker->created_at->format('U') + $request->duration * 60);
            if ($timeTracker->task) {
                $timeTracker->task->duration += (int)$request->duration;
                $timeTracker->task->save();
            }
        }
        $timeTracker->save();

        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\TimeTracker $timeTracker
     *
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy(TimeTracker $timeTracker)
    {
        $timeTracker->delete();

        return response()->json([], 204);
    }
}
