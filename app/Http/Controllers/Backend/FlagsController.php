<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;

// Models
use App\Models\Reply;
use App\Models\Thread;

// Requests
use Illuminate\Http\Request;

class FlagsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Store a new flag in the database.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Reply  $reply
     */
    public function store(Request $request, Reply $reply)
    {
        $reply->flag($request->reason);

        if (request()->expectsJson())
            return response(['status' => 'Flagged successfully!']);

        return back();
    }

    /**
     * Store a new flag in the database for a thread.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Thread  $thread
     */
    public function storeThreadFlag(Request $request, Thread $thread)
    {
        $thread->flag($request->reason);

        if (request()->expectsJson())
            return response(['status' => 'Flagged successfully!']);

        return back();
    }
}
