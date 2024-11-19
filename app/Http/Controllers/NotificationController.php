<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index(Request $request)
    {
        $notifications = $request->user()->notifications()->latest()->simplePaginate(10);

        $request->user()->unreadNotifications->markAsRead();

        return view('notification.index', compact('notifications'));
    }

    public function markAllAsRead(Request $request)
    {
        $request->user()->unreadNotifications->markAsRead();

        return redirect()->back()->with(['message' => 'All notifications marked as read']);
    }
}
