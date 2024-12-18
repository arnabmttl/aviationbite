<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;

// Models
use App\Models\Page;

// Services
use App\Services\PageService;

// Requests
use Illuminate\Http\Request;
use App\Http\Requests\Backend\PageStoreRequest;
use App\Http\Requests\Backend\PageDetailsUpdateRequest;
use App\Http\Requests\Backend\PageMetaUpdateRequest;

// Support Facades
use Illuminate\Support\Facades\Session;

class PagesController extends Controller
{
    /**
     * PageService instance to use various functions of PageService.
     *
     * @var \App\Services\PageService
     */
    protected $pageService;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('role:admin');
        $this->pageService = new PageService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pages = $this->pageService->getPaginatedListOfPages(20);
        
        if ($pages) {
            return view('backend.admin.page.index', compact('pages'));
        } else {
            Session::flash('failure', 'There is some problem in fetching pages at the moment. Please try again later.');

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
        return view('backend.admin.page.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\Backend\PageStoreRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PageStoreRequest $request)
    {
        $input = $request->validated();

        $result = $this->pageService->createPage($input);

        if ($result)
            Session::flash('success', 'The page has been added successfully.');
        else
            Session::flash('failure', 'There is some problem in adding the page.');

        return redirect(route('page.index'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Page  $page
     * @return \Illuminate\Http\Response
     */
    public function edit(Page $page)
    {
        return view('backend.admin.page.edit', compact('page'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\Backend\PageDetailsUpdateRequest  $request
     * @param  \App\Models\Page  $page
     * @return \Illuminate\Http\Response
     */
    public function update(PageDetailsUpdateRequest $request, Page $page)
    {
        $update = $request->validated();
        
        $result = $this->pageService->updatePageByObject($update, $page);

        if ($result)
            Session::flash('success', 'The page details has been updated successfully.');
        else
            Session::flash('failure', 'There is some problem in updating the page.');

        return redirect(route('page.edit', $page->id));
    }

    /**
     * Update the meta information of the page.
     *
     * @param  \App\Http\Requests\Backend\PageMetaUpdateRequest  $request
     * @param  \App\Models\Page  $page
     * @return \Illuminate\Http\Response
     */
    public function updateMetaInformation(PageMetaUpdateRequest $request, Page $page)
    {
        $update = $request->validated();
        
        $result = $this->pageService->updatePageByObject($update, $page);

        if ($result)
            Session::flash('success', 'The page details has been updated successfully.');
        else
            Session::flash('failure', 'There is some problem in updating the page.');

        Session::flash('selected_tab', 'pagemeta');
        return redirect(route('page.edit', $page->id));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Page  $page
     * @return \Illuminate\Http\Response
     */
    public function destroy(Page $page)
    {
        $result = $this->pageService->deletePageByObject($page);

        if ($result)
            Session::flash('success', 'The page has been deleted successfully.');
        else
            Session::flash('failure', 'There is some problem in deleting the page.');

        return redirect(route('page.index'));
    }
}
