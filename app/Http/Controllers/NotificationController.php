<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class NotificationController extends Controller
{
    public function getNotifications($user)
    {
       
       $user = User::find($user);
       if(!$user){
        return response()->json(['error' => 'User not found'], 404);
       }
       return response()->json(
        [
            'notifications' => $user->notifications,
            'unread_notifications' => $user->unreadNotifications
        ]
    );

    }

    public function markAsRead(Request $request)
    {
        $notification = $request->notification;
        $notification->markAsRead();
        return response()->json(['message' => 'Notification marked as read']);
    }
}
