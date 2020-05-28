<?php

namespace App\Http\Controllers;

use App\Http\Requests\TaskStoreRequest;
use App\Models\Employee;
use App\Models\Task;
use App\Models\Team;
use App\Notifications\TaskAttached;
use App\Notifications\TaskUpdated;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{

    public function __construct()
    {
        $this->authorizeResource(Task::class, 'task', ['except' => ['show', 'destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function indexAll()
    {
        $this->authorize('indexAll', 'App\Models\Task');

        return view('task.index')->with([
            'tasks'      => Task::all()->sortByDesc('updated_at'),
            'types'      => Task::$types,
            'statuses'   => Task::$statuses,
            'priorities' => Task::$priorities
        ]);
    }

    /**
     * Display a listing of the tasks
     * associated with the employee.
     *
     * @return Response
     */
    public function index()
    {
        if (Auth::user()->isAdmin()) {
            return redirect()->route('tasks.all');
        }
        $createdTasks     = Auth::user()->employee->createdTasks;
        $responsibleTasks = Auth::user()->employee->responsibleTasks;
        $assignedTasks    = Auth::user()->employee->assignedTasks;
        $teamTasks        = Auth::user()->employee->teams()->with('assignedTasks')->get()->pluck('assignedTasks');
        $allTasks         = $createdTasks->merge($assignedTasks)->merge($responsibleTasks);
        foreach ($teamTasks as $tasks) {
            foreach ($tasks as $task) {
                $allTasks->push($task);
            }
        }

        return view('task.index')->with([
            'tasks'      => $allTasks->unique()->sortByDesc('updated_at'),
            'types'      => Task::$types,
            'statuses'   => Task::$statuses,
            'priorities' => Task::$priorities
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('task.add')->with([
            'tasks'      => Task::all(),
            'types'      => Task::$types,
            'statuses'   => Task::$statuses,
            'priorities' => Task::$priorities,
            'employees'  => Employee::all(),
            'teams'      => Team::all(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param TaskStoreRequest $request
     *
     * @return Response
     */
    public function store(TaskStoreRequest $request)
    {
        $task = Auth::user()->employee->createdTasks()->create($request->all());
        /** @var Task $task * */
        $task->updateRelations($request, new TaskAttached($task));
        $attachments = [];
        if (!empty($request->file("attachments"))) {
            foreach ($request->file("attachments") as $index => $image) {
                if ($image) {
                    $ext           = $image->getClientOriginalExtension();
                    $path          = $image->storeAs('public/images/tasks', "task{$this->id}_attachment_$index.$ext");
                    $task_image    = str_replace('public/', 'storage/', $path);
                    $attachments[] = asset($task_image);
                }
            }
            $task->attachments = $attachments;
        }
        $task->save();

        return redirect()->route('tasks.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Task $task
     *
     * @return Response
     */
    public function edit(Task $task)
    {
        return view('task.edit')->with([
            'task'       => $task,
            'tasks'      => Task::all(),
            'types'      => Task::$types,
            'statuses'   => Task::$statuses,
            'priorities' => Task::$priorities,
            'employees'  => Employee::all(),
            'teams'      => Team::all()
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param TaskStoreRequest $request
     * @param Task             $task
     *
     * @return Response
     * @throws Exception
     */
    public function update(TaskStoreRequest $request, Task $task)
    {
        $data = $request->all();
        if (!empty($data['status'])) {
            switch ($data['status']) {
                case 'in_process':
                    if ($task->status != 'in_process') {
                        $data['started_at'] = now();
                    }
                    break;
                case 'done':
                    if ($task->status != 'done') {
                        $data['finished_at'] = now();
                    }
                    break;
                case 'closed':
                    $task->delete();

                    return redirect()->route('tasks.index');
                    break;
                default:
                    break;
            }
        }
        $task->update($data);
        $attachments = [];
        if (!empty($request->file("attachments"))) {
            foreach ($request->file("attachments") as $index => $image) {
                if ($image) {
                    $ext           = $image->getClientOriginalExtension();
                    $path          = $image->storeAs('public/images/tasks', "task{$this->id}_attachment_$index.$ext");
                    $task_image    = str_replace('public/', 'storage/', $path);
                    $attachments[] = asset($task_image);
                }
            }
            $task->attachments = $attachments;
        }
        $task->save();
        $task->updateRelations($request, new TaskUpdated($task));

        return redirect()->route('tasks.index');
    }
}
