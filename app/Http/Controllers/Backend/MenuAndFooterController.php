<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;

// Models
use App\Models\Footer;
use App\Models\MenuItem;

// Services
use App\Services\MenuItemService;

// Repositories
use App\Repositories\FooterRepository;

// Requests
use Illuminate\Http\Request;
use App\Http\Requests\Backend\MenuItemStoreRequest;

// Support Facades
use Illuminate\Support\Facades\Session;

class MenuAndFooterController extends Controller
{
    /**
     * FooterRepository instance to use various functions of FooterRepository.
     *
     * @var \App\Repositories\FooterRepository
     */
    protected $footerRepository;

    /**
     * MenuItemService instance to use various functions of MenuItemService.
     *
     * @var \App\Services\MenuItemService
     */
    protected $menuItemService;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('role:admin');
        $this->footerRepository = new FooterRepository;
        $this->menuItemService = new MenuItemService;
    }

    /**
     * Display a listing of the menu items.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexMenuItem()
    {
        $menuItms = $this->menuItemService->getAllMenuItemsWithoutParent();
        
        if ($menuItms) {
            return view('backend.admin.menu.index', compact('menuItms'));
        } else {
            Session::flash('failure', 'There is some problem in fetching menu items at the moment. Please try again later.');

            return redirect(route('dashboard'));
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function createMenuItem()
    {
        $menuItms = $this->menuItemService->getPluckedListOfMenuItemsWithoutParentByTitleAndId();

        return view('backend.admin.menu.create', compact('menuItms'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\Backend\MenuItemStoreRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function storeMenuItem(MenuItemStoreRequest $request)
    {
        $input = $request->validated();

        $result = $this->menuItemService->createMenuItem($input);

        if ($result)
            Session::flash('success', 'The menu item has been added successfully.');
        else
            Session::flash('failure', 'There is some problem in adding the menu item.');

        return redirect(route('menu.index'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\MenuItem  $menu
     * @return \Illuminate\Http\Response
     */
    public function editMenuItem(MenuItem $menu)
    {
        $menuItms = $this->menuItemService->getPluckedListOfMenuItemsWithoutParentByTitleAndId();

        return view('backend.admin.menu.edit', compact('menu', 'menuItms'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\Backend\MenuItemStoreRequest  $request
     * @param  \App\Models\MenuItem  $menu
     * @return \Illuminate\Http\Response
     */
    public function updateMenuItem(MenuItemStoreRequest $request, MenuItem $menu)
    {
        $update = $request->validated();
        
        $result = $this->menuItemService->updateMenuItemByObject($update, $menu);

        if ($result)
            Session::flash('success', 'The menu item details has been updated successfully.');
        else
            Session::flash('failure', 'There is some problem in updating the menu item.');

        return redirect(route('menu.index'));
    }

    /**
     * Move the menu item up in ordering.
     *
     * @param  \App\Models\MenuItem  $menu
     * @return \Illuminate\Http\Response
     */
    public function moveUpMenuItem(MenuItem $menu)
    {
        $result = $this->menuItemService->moveMenuItemUpByObject($menu);

        if ($result)
            Session::flash('success', 'The menu item moved up successfully.');
        else
            Session::flash('failure', 'There is some problem in moving up the menu item.');

        return redirect(route('menu.index'));
    }

    /**
     * Move the menu item down in ordering.
     *
     * @param  \App\Models\MenuItem  $menu
     * @return \Illuminate\Http\Response
     */
    public function moveDownMenuItem(MenuItem $menu)
    {
        $result = $this->menuItemService->moveMenuItemDownByObject($menu);

        if ($result)
            Session::flash('success', 'The menu item moved down successfully.');
        else
            Session::flash('failure', 'There is some problem in moving down the menu item.');

        return redirect(route('menu.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\MenuItem  $menu
     * @return \Illuminate\Http\Response
     */
    public function destroyMenuItem(MenuItem $menu)
    {
        $result = $this->menuItemService->deleteMenuItemByObject($menu);

        if ($result)
            Session::flash('success', 'The menu item has been deleted successfully.');
        else
            Session::flash('failure', 'There is some problem in deleting the menu item.');

        return redirect(route('menu.index'));
    }

    /**
     * Display page to edit footer.
     *
     * @return \Illuminate\Http\Response
     */
    public function editFooter()
    {
        $footerObj = $this->footerRepository->getFirstFooter();
        
        if ($footerObj) {
            return view('backend.admin.footer.edit', compact('footerObj'));
        } else {
            Session::flash('failure', 'There is some problem in fetching footer at the moment. Please try again later.');

            return redirect(route('dashboard'));
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Footer  $footerObj
     * @return \Illuminate\Http\Response
     */
    public function updateFooter(Request $request, Footer $footerObj)
    {
        $result = $this->footerRepository->updateFooterByObject(['description' => $request->description], $footerObj);

        if ($result)
            Session::flash('success', 'The footer details has been updated successfully.');
        else
            Session::flash('failure', 'There is some problem in updating the footer.');

        return redirect(route('footer.edit'));
    }
}