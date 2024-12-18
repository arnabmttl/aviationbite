<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;

// Models
use App\Models\Section;

// Services
use App\Services\SectionService;
use App\Services\PageService;
use App\Services\CollectionService;

// Repositories
use App\Repositories\SectionViewRepository;

// Requests
use Illuminate\Http\Request;
use App\Http\Requests\Backend\SectionStoreRequest;
use App\Http\Requests\Backend\SectionDetailsUpdateRequest;
use App\Http\Requests\Backend\AddBannerForPageRequest;
use App\Http\Requests\Backend\AddFaqRequest;

// Support Facades
use Illuminate\Support\Facades\Session;

class SectionsController extends Controller
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
     * Show the form for creating the specified resource.
     *
     * @param  string  $type
     * @param  int  $typeId
     * @return \Illuminate\Http\Response
     */
    public function create($type, $typeId)
    {
        if (in_array($type, ['page'])) {
            switch ($type) {
                case 'page':
                    if ($item = (new PageService)->getFirstPageById($typeId)) {
                        $breadcrumbs = '<li class="breadcrumb-item">
                                            <a href="'.route('page.index').'">
                                                Pages
                                            </a>
                                        </li>
                                        <li class="breadcrumb-item">
                                            <a href="'.route('page.edit', $typeId).'">
                                                Edit Page
                                            </a>
                                        </li>';
                    } else {
                        abort(404);
                    }

                    break;
                
                default: abort(404);
            }

            $sectionViews = (new SectionViewRepository)->getPluckedListOfSectionViewsByNameAndTypeExcludingSome([]);
            $collections = (new CollectionService)->getPluckedListOfCollections();

            $cancelUrl = route($type.'.edit', $typeId);

            return view('backend.admin.section.create', compact('item', 'breadcrumbs', 'sectionViews', 'type', 'cancelUrl', 'collections'));
        }

        abort(404);   
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\Backend\SectionStoreRequest  $request
     * @param  string  $type
     * @param  int  $typeId
     * @return \Illuminate\Http\Response
     */
    public function store(SectionStoreRequest $request, $type, $typeId)
    {
        $input = $request->validated();
        $input['type'] = $type;
        $input['typeId'] = $typeId;
        
        $result = $this->sectionService->createSection($input);
        
        if ($result)
            Session::flash('success', 'The section has been added successfully.');
        else
            Session::flash('failure', 'There is some problem in adding the section.');

        Session::flash('selected_tab', $type.'section');

        return redirect(route($type.'.edit', $typeId));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  string  $type
     * @param  \App\Models\Section  $section
     * @return \Illuminate\Http\Response
     */
    public function edit($type, Section $section)
    {
        if (in_array($type, ['page'])) {
            /**
             * Set breadcrumbs depending on the pageable type.
             */
            $item = $section->pageable;

            $packages = array();
            switch ($section->pageable_type) {
                case 'App\Models\Page':
                    $breadcrumbs = '<li class="breadcrumb-item">
                                        <a href="'.route('page.index').'">
                                            Pages
                                        </a>
                                    </li>
                                    <li class="breadcrumb-item">
                                        <a href="'.route('page.edit', $item->id).'">
                                            Edit Page
                                        </a>
                                    </li>';                

                    break;

                default: abort(404);
            }

            $cancelUrl = route($type.'.edit', $item->id);

            return view('backend.admin.section.edit', compact('section', 'item', 'breadcrumbs', 'type', 'cancelUrl'));
        }
        
        abort(404);   
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\Backend\SectionDetailsUpdateRequest  $request
     * @param  \App\Models\Section  $section
     * @return \Illuminate\Http\Response
     */
    public function update(SectionDetailsUpdateRequest $request, Section $section)
    {
        $update = $request->validated();
        
        $result = $this->sectionService->updateSectionByObject($update, $section);

        if ($result)
            Session::flash('success', 'The section details has been updated successfully.');
        else
            Session::flash('failure', 'There is some problem in updating the section details.');

        return redirect(route('section.edit', [$section->pageable_type_url, $section->id]));
    }

    /**
     * Destroy the specified resource.
     *
     * @param  string  $type
     * @param  \App\Models\Section  $section
     * @return \Illuminate\Http\Response
     */
    public function destroy($type, Section $section)
    {
        if (in_array($type, ['page'])) {
            /**
             * Get the item this section is associated with .
             */
            $item = $section->pageable;

            switch ($section->pageable_type) {
                case 'App\Models\Page':
                    $result = $this->sectionService->deleteSectionByObject($section);
                    
                    if ($result)
                        Session::flash('success', 'The section deleted successfully.');
                    else
                        Session::flash('failure', 'There is some problem in deleting the section.');

                    Session::flash('selected_tab', 'pagesection');
                    return redirect(route('page.edit', $item->id));

                default: abort(404);
            }
        }
        
        abort(404);   
    }

    /**
     * Add banner for page.
     *
     * @param  \App\Http\Requests\Backend\AddBannerForPageRequest  $request
     * @param  \App\Models\Section  $section
     * @return \Illuminate\Http\Response
     */
    public function addBannerForPage(AddBannerForPageRequest $request, Section $section)
    {
        $input = $request->validated();
        
        $result = $this->sectionService->addBannerForPageBySectionObject($input, $section);

        if ($result)
            Session::flash('success', 'The section content has been updated successfully.');
        else
            Session::flash('failure', 'There is some problem in updating the section content.');

        return redirect(route('section.edit', [$section->pageable_type_url, $section->id]));
    }

    /**
     * Move the section up in ordering.
     *
     * @param  \App\Models\Section  $section
     * @return \Illuminate\Http\Response
     */
    public function moveUp(Section $section)
    {
        $result = $this->sectionService->moveSectionUpByObject($section);

        if ($result)
            Session::flash('success', 'The section moved up successfully.');
        else
            Session::flash('failure', 'There is some problem in moving up the section.');

        /**
         * Redirect to the corresponding page depending on the pageable type.
         */
        switch ($section->pageable_type) {
            case 'App\Models\Page':
                Session::flash('selected_tab', 'pagesection');
                return redirect(route('page.edit', $section->pageable_id));
            
            default: abort(404);
        }
    }

    /**
     * Move the section down in ordering.
     *
     * @param  \App\Models\Section  $section
     * @return \Illuminate\Http\Response
     */
    public function moveDown(Section $section)
    {
        $result = $this->sectionService->moveSectionDownByObject($section);

        if ($result)
            Session::flash('success', 'The section moved down successfully.');
        else
            Session::flash('failure', 'There is some problem in moving down the section.');

        /**
         * Redirect to the corresponding page depending on the pageable type.
         */
        switch ($section->pageable_type) {
            case 'App\Models\Page':
                Session::flash('selected_tab', 'pagesection');
                return redirect(route('page.edit', $section->pageable_id));
            
            default: abort(404);
        }
    }

    /**
     * Add faq.
     *
     * @param  \App\Http\Requests\Backend\AddFaqRequest  $request
     * @param  \App\Models\Section  $section
     * @return \Illuminate\Http\Response
     */
    public function addFaq(AddFaqRequest $request, Section $section)
    {
        $input = $request->validated();
        
        $result = $this->sectionService->addFaqBySectionObject($input, $section);

        if ($result)
            Session::flash('success', 'The section content has been updated successfully.');
        else
            Session::flash('failure', 'There is some problem in updating the section content.');

        return redirect(route('section.edit', [$section->pageable_type_url, $section->id]));
    }
}
