<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;

// Models
use App\Models\CollectionItem;
use App\Models\Section;
use App\Models\Collection;

// Services
use App\Services\CollectionService;
use App\Services\CourseService;

// Requests
use Illuminate\Http\Request;
use App\Http\Requests\Backend\CollectionCreateRequest;
use App\Http\Requests\Backend\CollectionEditRequest;
use App\Http\Requests\Backend\CollectionItemCreateRequest;

// Support Facades
use Illuminate\Support\Facades\Session;

class CollectionsController extends Controller
{
    /**
     * CollectionService instance to use various functions of CollectionService.
     *
     * @var \App\Services\CollectionService
     */
    protected $collectionService;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('role:admin');
        $this->collectionService = new CollectionService;
    }

    /**
     * Move the collection item up in ordering.
     *
     * @param  \App\Models\Section  $section
     * @param  \App\Models\CollectionItem  $item
     * @return \Illuminate\Http\Response
     */
    public function moveUp(Section $section, CollectionItem $item)
    {
        $result = $this->collectionService->moveCollectionItemUpByObject($item);

        if ($result)
            Session::flash('success', 'The item moved up successfully.');
        else
            Session::flash('failure', 'There is some problem in moving up the item.');

        Session::flash('selected_tab', 'sectioncontent');
        return redirect(route('section.edit', [$section->pageable_type_url, $section->id]));
    }

    /**
     * Move the collection item down in ordering.
     *
     * @param  \App\Models\Section  $section
     * @param  \App\Models\CollectionItem  $item
     * @return \Illuminate\Http\Response
     */
    public function moveDown(Section $section, CollectionItem $item)
    {
        $result = $this->collectionService->moveCollectionItemDownByObject($item);

        if ($result)
            Session::flash('success', 'The item moved down successfully.');
        else
            Session::flash('failure', 'There is some problem in moving down the item.');

        Session::flash('selected_tab', 'sectioncontent');
        return redirect(route('section.edit', [$section->pageable_type_url, $section->id]));
    }

    /**
     * Delete collection item.
     *
     * @param  \App\Models\Section  $section
     * @param  \App\Models\CollectionItem  $item
     * @return \Illuminate\Http\Response
     */
    public function destroyCollectionItem(Section $section, CollectionItem $item)
    {
        $result = $this->collectionService->deleteCollectionItemByObject($item);

        if ($result)
            Session::flash('success', 'The item has been removed successfully.');
        else
            Session::flash('failure', 'There is some problem in removing the item.');

        Session::flash('selected_tab', 'sectioncontent');
        return redirect(route('section.edit', [$section->pageable_type_url, $section->id]));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $collections = $this->collectionService->getPaginatedListOfCollections(20);
        
        if ($collections) {
            return view('backend.admin.collection.index', compact('collections'));
        } else {
            Session::flash('failure', 'There is some problem in fetching collections at the moment. Please try again later.');

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
        $courses = (new CourseService)->getPluckedListOfCoursesByNameAndId();

        if ($courses)
            return view('backend.admin.collection.create', compact('courses'));
        else {
            Session::flash('failure', 'There is some problem in creating collection at the moment. Please try again later.');

            return redirect(route('dashboard'));
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\Backend\CollectionCreateRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CollectionCreateRequest $request)
    {
        $input = $request->validated();
        
        $result = $this->collectionService->createCollectionWithItem($input);

        if ($result) {
            Session::flash('success', 'The collection has been added successfully.');

            Session::flash('selected_tab', 'collectionitem');
            return redirect(route('collection.edit', $result->id));
        }
        else {
            Session::flash('failure', 'There is some problem in adding the collection.');

            return redirect(route('collection.index'));
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Collection  $collection
     * @return \Illuminate\Http\Response
     */
    public function edit(Collection $collection)
    {
        switch ($collection->items->first()->collectable_type) {
            case 'App\Models\Course':
                $items = (new CourseService)->getPluckedListOfCoursesByNameAndId();
                break;
            
            default: abort(404);
        }

        return view('backend.admin.collection.edit', compact('collection', 'items'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\Backend\CollectionEditRequest  $request
     * @param  \App\Models\Collection  $collection
     * @return \Illuminate\Http\Response
     */
    public function update(CollectionEditRequest $request, Collection $collection)
    {
        $update = $request->validated();
        
        $result = $this->collectionService->updateCollectionByObject($update, $collection);

        if ($result)
            Session::flash('success', 'The collection details has been updated successfully.');
        else
            Session::flash('failure', 'There is some problem in updating the collection.');

        return redirect(route('collection.edit', $collection->id));
    }

    /**
     * Add item for the collection.
     *
     * @param  \App\Http\Requests\Backend\CollectionItemCreateRequest  $request
     * @param  \App\Models\Collection  $collection
     * @return \Illuminate\Http\Response
     */
    public function storeItem(CollectionItemCreateRequest $request, Collection $collection)
    {
        $input = $request->validated();
        
        $result = $this->collectionService->createItemByCollectionObject($input, $collection);

        if ($result)
            Session::flash('success', 'The item has been added successfully.');
        else
            Session::flash('failure', 'There is some problem in adding the item.');

        Session::flash('selected_tab', 'collectionitem');
        return redirect(route('collection.edit', $collection->id));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Collection  $collection
     * @return \Illuminate\Http\Response
     */
    public function destroy(Collection $collection)
    {
        $result = $this->collectionService->deleteCollectionByObject($collection);

        if ($result)
            Session::flash('success', 'The collection has been deleted successfully.');
        else
            Session::flash('failure', 'There is some problem in deleting the collection.');

        return redirect(route('collection.index'));
    }

    /**
     * Move the collection item up in ordering.
     *
     * @param  \App\Models\Collection  $collection
     * @param  \App\Models\CollectionItem  $item
     * @return \Illuminate\Http\Response
     */
    public function moveUpDirect(Collection $collection, CollectionItem $item)
    {
        $result = $this->collectionService->moveCollectionItemUpByObject($item);

        if ($result)
            Session::flash('success', 'The item moved up successfully.');
        else
            Session::flash('failure', 'There is some problem in moving up the item.');

        Session::flash('selected_tab', 'collectionitem');
        return redirect(route('collection.edit', $collection->id));
    }

    /**
     * Move the collection item down in ordering.
     *
     * @param  \App\Models\Collection  $collection
     * @param  \App\Models\CollectionItem  $item
     * @return \Illuminate\Http\Response
     */
    public function moveDownDirect(Collection $collection, CollectionItem $item)
    {
        $result = $this->collectionService->moveCollectionItemDownByObject($item);

        if ($result)
            Session::flash('success', 'The item moved down successfully.');
        else
            Session::flash('failure', 'There is some problem in moving down the item.');

        Session::flash('selected_tab', 'collectionitem');
        return redirect(route('collection.edit', $collection->id));
    }

    /**
     * Delete collection item.
     *
     * @param  \App\Models\Collection  $collection
     * @param  \App\Models\CollectionItem  $item
     * @return \Illuminate\Http\Response
     */
    public function destroyCollectionItemDirect(Collection $collection, CollectionItem $item)
    {
        $result = $this->collectionService->deleteCollectionItemByObject($item);

        if ($result)
            Session::flash('success', 'The item has been removed successfully.');
        else
            Session::flash('failure', 'There is some problem in removing the item.');

        Session::flash('selected_tab', 'collectionitem');
        return redirect(route('collection.edit', $collection->id));
    }
}
