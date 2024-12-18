<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;

use App\Models\User;

use Illuminate\Http\Request;

class UserNotificationsController extends Controller
{
	/**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function destroy(User $user, $notificationId)
    {
        $notification = auth()->user()->unreadNotifications()->findOrFail($notificationId);
        
    	$notification->markAsRead();

        return redirect($notification->data['link']);
    }

    public function index(User $user)
    {
    	return auth()->user()->unreadNotifications();
    }
}
