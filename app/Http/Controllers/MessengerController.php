<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\User;
use App\Notifications\MessageReceived;
use Carbon\Carbon;
use Cmgmyr\Messenger\Models\Participant;
use Cmgmyr\Messenger\Models\Thread;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class MessengerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        // All threads that user is participating in
        $threads = Thread::forUser(Auth::id())->latest()->get();

        return view('messaging.index')->with([
            'threads' => $threads
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('messaging.add')->with([
            'employees' => Employee::with('user')->get()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     *
     * @return Response
     * @throws Exception
     */
    public function store(Request $request)
    {
        $thread = Thread::create([
            'subject' => $request->subject
        ]);

        $message = Auth::user()->messages()->create([
            'thread_id' => $thread->id,
            'body' => $request->body
        ]);

        Participant::create([
            'thread_id' => $thread->id,
            'user_id'   => Auth::id(),
            'last_read' => new Carbon
        ]);

        /*  @var Thread $thread */
        $thread->addParticipant($request->to);
        User::find($request->to)->notify(new MessageReceived($message));

        return redirect()->route('threads.show', $thread);
    }

    /**
     * Display the specified resource.
     *
     * @param Thread $thread
     *
     * @return Response
     */
    public function show(Thread $thread)
    {
        $thread->markAsRead(Auth::id());
        Auth::user()->unreadNotifications()
            ->where('data->type', 'message')
            ->where('data->thread_id', $thread->id)
            ->get()->markAsRead();

        return view('messaging.show')->with([
            'thread' => $thread->load('messages.user.employee'),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Thread  $thread
     *
     * @return Response
     * @throws Exception
     */
    public function update(Request $request, Thread $thread)
    {
        /*  @var User $to */
        $to = Participant::where('thread_id', $thread->id)->where('user_id', '!=', Auth::id())->first()->user;
        // Message
        $message = Auth::user()->messages()->create([
            'thread_id' => $thread->id,
            'body' => $request->reply
        ]);
        // Add replier as a participant
        $participant = Participant::firstOrCreate([
            'thread_id' => $thread->id,
            'user_id'   => Auth::id(),
        ]);

        $participant->last_read = new Carbon;
        $participant->save();
        $to->notify(new MessageReceived($message));
//		// Recipients
//		if (Request::has('recipients')) {
//			$thread->addParticipant(Request::input('recipients'));
//		}

        return redirect()->route('threads.show', $thread);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Thread $thread
     *
     * @return Response
     * @throws Exception
     */
    public function destroy(Thread $thread)
    {
        $thread->delete();

        return redirect()->route('threads.index');
    }
}
