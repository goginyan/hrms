<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Notifications\DatabaseNotification as Notification;

class NotificationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\View\View
     */
    public function index()
    {
        $notifications = Auth::user()->notifications()->where('data->type', '!=', 'message')->get();
        if (request()->ajax()) {
            return response()->json($notifications->jsonSerialize());
        }

        return view('notifications.index')->with([
            'notifications' => $notifications
        ]);
    }

    /**
     * Mark as read the notification
     *
     * @param Request      $request
     * @param Notification $notification
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Notification $notification)
    {
        if (request()->ajax() && request('mark_read')) {

            $notification->update(['read_at' => now()]);

            return response()->json(['message' => 'ok', 'notification' => $notification->jsonSerialize()]);
        }

        return back();
    }

    /**
     * Mark as read all notifications
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function readAll()
    {
        Auth::user()->unreadNotifications()->where('data->type', '!=', 'message')->get()->markAsRead();

        return response()->json(['message' => 'ok']);
    }
}
