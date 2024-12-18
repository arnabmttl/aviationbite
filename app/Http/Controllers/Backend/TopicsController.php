<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;

// Models
use App\Models\Topic;

// Services
use App\Services\TopicService;

// Requests
use Illuminate\Http\Request;
use App\Http\Requests\Backend\TopicCreateRequest;
use App\Http\Requests\Backend\TopicEditRequest;

// Support Facades
use Illuminate\Support\Facades\Session;

class TopicsController extends Controller
{
    /**
     * TopicService instance to use various functions of TopicService.
     *
     * @var \App\Services\TopicService
     */
    protected $topicService;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('role:admin');
        $this->topicService = new TopicService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $topics = $this->topicService->getPaginatedListOfTopicsOrderedByUpdatedAt(5);

        if ($topics)
            return view('backend.admin.topic.index', compact('topics'));
        else {
            Session::flash('failure', 'There is some problem in fetching topics at the moment. Kindly try after some time.');

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
        $topics = $this->topicService->getPluckedListOfTopicsByNameAndId();
        
        if ($topics)
            return view('backend.admin.topic.create', compact('topics'));
        else {
            Session::flash('failure', 'There is some problem in fetching topics at the moment. Kindly try after some time.');

            return redirect(route('dashboard'));
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\Backend\TopicCreateRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TopicCreateRequest $request)
    {
        $input = $request->validated();
        
        $result = $this->topicService->createTopic($input);
        
        if ($result)
            Session::flash('success', 'The topic has been added successfully.');
        else
            Session::flash('failure', 'There is some problem in adding the topic.');

        return redirect(route('topic.index'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Topic  $topic
     * @return \Illuminate\Http\Response
     */
    public function edit(Topic $topic)
    {
        $topics = $this->topicService->getPluckedListOfTopicsByNameAndId();
        
        if ($topics)
            return view('backend.admin.topic.edit', compact('topics', 'topic'));
        else {
            Session::flash('failure', 'There is some problem in fetching topics at the moment. Kindly try after some time.');

            return redirect(route('dashboard'));
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\Backend\TopicEditRequest  $request
     * @param  \App\Models\Topic  $topic
     * @return \Illuminate\Http\Response
     */
    public function update(TopicEditRequest $request, Topic $topic)
    {
        $update = $request->validated();
        
        $result = $this->topicService->updateTopicByObject($update, $topic);

        if ($result)
            Session::flash('success', 'The topic has been updated successfully.');
        else
            Session::flash('failure', 'There is some problem in updating the topic.');

        return redirect(route('topic.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Topic  $topic
     * @return \Illuminate\Http\Response
     */
    public function destroy(Topic $topic)
    {
        $result = $this->topicService->deleteTopicByObject($topic);
        
        if ($result) 
            Session::flash('success', 'The topic has been deleted successfully.');
        else
            Session::flash('failure', 'There is some problem in deleting the topic.');

        return redirect(route('topic.index'));
    }
}
