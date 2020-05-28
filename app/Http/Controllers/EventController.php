<?php

namespace App\Http\Controllers;

use App\Http\Requests\EventStoreRequest;
use App\Models\Department;
use App\Models\Event;
use App\Notifications\EventCreated;
use App\Notifications\EventUpdated;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class EventController extends Controller
{

    public function __construct()
    {
        $this->authorizeResource(Event::class, 'event', ['except' => ['create', 'edit']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $events        = Auth::user()->employee->events()->where('start_date', '>=', today())->with('creator')->get();
        $createdEvents = Auth::user()->employee->createdEvents()->with('creator')->get();

        return view('event.index')->with([
            'events'      => Auth::user()->isAdmin() ? Event::orderBy('start_date')->get() : $events->merge($createdEvents)->unique(),
            'countries'   => countries(true),
            'departments' => Department::with('employees')->get()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param EventStoreRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(EventStoreRequest $request)
    {
        if (Auth::user()->isAdmin()) {
            $event = Event::create($request->all());
        } else {
            $event = Auth::user()->employee->createdEvents()->create($request->all());
        }
        $event->members()->attach($request->members);
        foreach ($event->members as $member) {
            $member->user->notify(new EventCreated($event));
        }
        $file = $request->file('file');
        if ($file) {
            $ext  = $file->getClientOriginalExtension();
            $path = $file->storeAs('public/events', "file{$event->id}.$ext");

            $newPath     = str_replace('public/', 'storage/', $path);
            $event->file = asset($newPath);
        }
        $event->save();

        return redirect()->route('events.index');
    }

    /**
     * Display the specified resource.
     *
     * @param Event $event
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(Event $event)
    {
        return view('event.show')->with([
            'event'       => $event,
            'countries'   => countries(true),
            'departments' => Department::with('employees')->get()
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param EventStoreRequest $request
     * @param Event             $event
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(EventStoreRequest $request, Event $event)
    {
        $event->update($request->all());
        $event->members()->sync($request->members);
        foreach ($event->members as $member) {
            $member->user->notify(new EventUpdated($event));
        }
        $file = $request->file('file');
        if ($file) {
            $ext  = $file->getClientOriginalExtension();
            $path = $file->storeAs('public/events', "file{$event->id}.$ext");

            $newPath     = str_replace('public/', 'storage/', $path);
            $event->file = asset($newPath);
        }
        $event->save();

        return redirect()->route('events.show', ['event' => $event->id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Event $event
     *
     * @return Response
     * @throws Exception
     */
    public function destroy(Event $event)
    {
        $event->delete();

        return redirect()->route('events.index');
    }
}
