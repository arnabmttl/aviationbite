<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;

// Models
use App\Models\Channel;
use App\Models\Thread;

// Requests
use Illuminate\Http\Request;

class ThreadSubscriptionsController extends Controller
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

    public function store(Channel $channel, Thread $thread)
    {
    	$thread->subscribe();

        return redirect(route('thread.show', [$channel->slug, $thread->id]));
    }

    public function destroy(Channel $channel, Thread $thread)
    {
        $thread->unsubscribe();

        return redirect(route('thread.show', [$channel->slug, $thread->id]));
    }
}
