<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Thread;
use App\Models\User;
use App\Models\Channel;
use App\Models\Banner;
use App\Filters\ThreadFilters;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Events\ThreadViewed;
// Support Facades
use Illuminate\Support\Facades\Session;

class ThreadsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except(['index' , 'show', 'search']);
    }

    /**
     * Display a listing of the resource.
     *
     * @param Channel $channel
     * @param ThreadFilters $filters
     * @return \Illuminate\Http\Response
     *
     */
    public function index(Channel $channel, ThreadFilters $filters)
    {
        if (request()->has('subscribed') && auth()->check()) {
            if ($channel->exists) {
                $threads = request()->user()->subscribedThreads()->where('channel_id', $channel->id)->orderBy('id','desc')->paginate(5);
            } else {
                $threads = request()->user()->subscribedThreads()->orderBy('id','desc')->paginate(5);
            }
        } else {
            $threads = $this->getThreads($channel, $filters);
        }

        if (request()->wantsJson()) {
            return $threads;
        };

        $banners = Banner::where('set_page_for', 'forum')->get();
        return view('backend.student.threads.index')->with(['threads' => $threads, 'filters' => $filters, 'channel' => $channel, 'search' => false , 'banners' => $banners]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.student.threads.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'body' => 'required',
            'channel_id' => 'required|exists:channels,id'
        ]);

        $thread = Thread::create([
            'user_id' => Auth::id(),
            'channel_id' => request('channel_id'),
            'title' => request('title'),
            'body'=> request('body')
        ]);

        return redirect($thread->path());
    }

    /**
     * Search threads.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request, Channel $channel, ThreadFilters $filters)
    {
        $request->validate([
            'search' => 'required|string|max:255'
        ]);

        $search = $request->search;
        $threads = Thread::where('title', 'like', '%'.$search.'%')->orderBy('id','desc')->paginate(5);

        $banners = Banner::where('set_page_for', 'forum')->get();

        return view('backend.student.threads.index')->with(['threads' => $threads, 'filters' => $filters, 'channel' => $channel, 'search' => $search, 'banners' => $banners]);
    }

    /**
     * Display the specified resource.
     *
     * @param  integer     $channelId
     * @param  \App\Models\Thread  $thread
     * @return \Illuminate\Http\Response
     */
    public function show($channelId, Thread $thread)
    {
        /**
         * Call the thread viewed event
         */
        event(new ThreadViewed($thread));

        return view('backend.student.threads.show', [
            'thread' => $thread,
            'channelId' => $channelId,
            'replies' => $thread->replies()->orderBy('id', 'desc')->paginate(5)
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Thread  $thread
     * @return \Illuminate\Http\Response
     */
    public function edit(Thread $thread)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Thread  $thread
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Thread $thread)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Channel  $channel
     * @param  \App\Models\Thread  $thread
     * @return \Illuminate\Http\Response
     */
    public function destroy(Channel $channel, Thread $thread)
    {
        $this->authorize('update', $thread);

        $thread->replies->each->delete();
        $thread->delete();

        if (auth()->user()->hasRole(['admin'])) {
            Session::flash('success', 'The question has been deleted successfully.');

            return redirect(route('flagged.replies.index'));
        }

        return redirect(route('user.profile', request()->user()->username));
    }

    /**
     * Fetch all relevant threads.
     *
     * @param Channel       $channel
     * @param ThreadFilters $filters
     * @return mixed
     */
    public function getThreads(Channel $channel, ThreadFilters $filters)
    {
        $threads = Thread::latest()->filter($filters);

        if ($channel->exists) {
            $threads->where('channel_id', $channel->id);
        }
        return $threads->paginate(5);
    }
}
