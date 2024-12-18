<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;

// Models
use App\Models\Channel;

// Repositories
use App\Repositories\ChannelRepository;

// Requests
use Illuminate\Http\Request;
use App\Http\Requests\Backend\ChannelStoreRequest;
use App\Http\Requests\Backend\ChannelUpdateRequest;

// Support Facades
use Illuminate\Support\Facades\Session;

class ChannelsController extends Controller
{
    /**
     * ChannelRepository instance to use various functions of ChannelRepository.
     *
     * @var \App\Repositories\ChannelRepository
     */
    protected $channelRepository;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('role:admin');
        $this->channelRepository = new ChannelRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $spaces = $this->channelRepository->getListOfAllChannelsOrderedByName();

        if ($spaces)
            return view('backend.admin.channel.index', compact('spaces'));
        else {
            Session::flash('failure', 'There is some problem in fetching spaces at the moment. Kindly try after some time.');

            return redirect(route('dashboard'));
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.admin.channel.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\Backend\ChannelStoreRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ChannelStoreRequest $request)
    {
        $input = $request->validated();
        
        $result = $this->channelRepository->createChannel($input);
        
        if ($result)
            Session::flash('success', 'The space has been added successfully.');
        else
            Session::flash('failure', 'There is some problem in adding the space.');

        return redirect(route('channel.index'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Channel  $channel
     * @return \Illuminate\Http\Response
     */
    public function edit(Channel $channel)
    {
        return view('backend.admin.channel.edit', compact('channel'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\Backend\ChannelUpdateRequest  $request
     * @param  \App\Models\Channel  $channel
     * @return \Illuminate\Http\Response
     */
    public function update(ChannelUpdateRequest $request, Channel $channel)
    {
        $update = $request->validated();
        
        $result = $this->channelRepository->updateChannelByObject($update, $channel);

        if ($result)
            Session::flash('success', 'The space has been updated successfully.');
        else
            Session::flash('failure', 'There is some problem in updating the space.');

        return redirect(route('channel.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Channel  $channel
     * @return \Illuminate\Http\Response
     */
    public function destroy(Channel $channel)
    {
        $result = $this->channelRepository->deleteChannelByObject($channel);
        
        if ($result) 
            Session::flash('success', 'The space has been deleted successfully.');
        else
            Session::flash('failure', 'There is some problem in deleting the space.');

        return redirect(route('channel.index'));
    }
}
