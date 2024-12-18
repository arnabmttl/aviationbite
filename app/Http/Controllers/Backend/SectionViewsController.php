<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;

// Models
use App\Models\SectionView;

// Services
use App\Services\SectionService;

// Requests
use Illuminate\Http\Request;
use App\Http\Requests\Backend\SectionViewCreateRequest;
use App\Http\Requests\Backend\SectionViewEditRequest;

// Support Facades
use Illuminate\Support\Facades\Session;

class SectionViewsController extends Controller
{
    /**
     * SectionService instance to use various functions of SectionService.
     *
     * @var \App\Services\SectionService
     */
    protected $sectionService;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('role:admin');
        $this->sectionService = new SectionService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sectionViews = $this->sectionService->getPaginatedListOfSectionViewsOrderedByUpdatedAt(20);

        if ($sectionViews)
            return view('backend.admin.section-view.index', compact('sectionViews'));
        else {
            Session::flash('failure', 'There is some problem in fetching section views at the moment. Kindly try after some time.');

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
        return view('backend.admin.section-view.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\Backend\SectionViewCreateRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SectionViewCreateRequest $request)
    {
        $input = $request->validated();
        
        $result = $this->sectionService->createSectionView($input);
        
        if ($result)
            Session::flash('success', 'The section view has been added successfully.');
        else
            Session::flash('failure', 'There is some problem in adding the section view.');

        return redirect(route('section-view.index'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\SectionView  $sectionView
     * @return \Illuminate\Http\Response
     */
    public function edit(SectionView $sectionView)
    {
        return view('backend.admin.section-view.edit', compact('sectionView'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\Backend\SectionViewEditRequest  $request
     * @param  \App\Models\SectionView  $sectionView
     * @return \Illuminate\Http\Response
     */
    public function update(SectionViewEditRequest $request, SectionView $sectionView)
    {
        $update = $request->validated();
        
        $result = $this->sectionService->updateSectionViewByObject($update, $sectionView);

        if ($result)
            Session::flash('success', 'The section view has been updated successfully.');
        else
            Session::flash('failure', 'There is some problem in updating the section view.');

        return redirect(route('section-view.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\SectionView  $sectionView
     * @return \Illuminate\Http\Response
     */
    public function destroy(SectionView $sectionView)
    {
        $result = $this->sectionService->deleteSectionViewByObject($sectionView);
        
        if ($result) 
            Session::flash('success', 'The section view has been deleted successfully.');
        else
            Session::flash('failure', 'There is some problem in deleting the section view.');

        return redirect(route('section-view.index'));
    }
}
