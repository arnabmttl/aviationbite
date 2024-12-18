<?php

namespace App\Repositories;

// Model for the repository
use App\Models\MenuItem;

// Support Facades
use Illuminate\Support\Facades\Log;

// Exception
use Exception;

class MenuItemRepository extends BaseRepository
{
	/**
	 * Create a new repository instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * Get the total number of menu items available.
	 *
	 * @return int|boolean
	 */
	public function getTotalMenuItems()
	{
		try {
			return MenuItem::count();
		} catch(Exception $e) {
			Log::channel('menu')->error('[MenuItemRepository:getTotalMenuItems] Total number of menu items not fetched because an exception occurred: ');
			Log::channel('menu')->error($e->getMessage());

			return false;
		}
	}

	/**
	 * Create a new menu item.
	 *
	 * @param  array  $input
	 * @return \App\Models\MenuItem|boolean
	 */
	public function createMenuItem($input)
	{
		try {
			return MenuItem::create($input);
		} catch (Exception $e) {
			Log::channel('menu')->error('[MenuItemRepository:createMenuItem] New menu item not created because an exception occurred: ');
			Log::channel('menu')->error($e->getMessage());

			return false;
		}
	}

	/**
	 * Get plucked list of menu items by title and id.
	 *
	 * @return \Illuminate\Support\Collection|boolean
	 */
	public function getPluckedListOfMenuItemsByTitleAndId()
	{
		try {
			return MenuItem::pluck('title', 'id');
		} catch(Exception $e) {
			Log::channel('menu')->error('[MenuItemRepository:getPluckedListOfMenuItemsByTitleAndId] Plucked list of menu items by title and id not fetched because an exception occurred: ');
			Log::channel('menu')->error($e->getMessage());

			return false;
		}
	}

	/**
	 * Get all menu items available without parent.
	 *
	 * @return \Illuminate\Database\Eloquent\Collection|boolean
	 */
	public function getAllMenuItemsWithoutParent()
	{
		try {
			return MenuItem::whereNull('parent_id')
							 ->orderBy('sort_order')
							 ->get();
		} catch(Exception $e) {
			Log::channel('menu')->error('[MenuItemRepository:getAllMenuItemsWithoutParent] All menu items without parent not fetched because an exception occurred: ');
			Log::channel('menu')->error($e->getMessage());

			return false;
		}
	}

	/**
	 * Update the menu item by object.
	 *
	 * @param  array  $update
	 * @param  \App\Models\MenuItem  $menuItem
	 * @return boolean
	 */
	public function updateMenuItemByObject($update, $menuItem)
	{
		try {
			return $menuItem->update($update);
		} catch (Exception $e) {
			Log::channel('menu')->error('[MenuItemRepository:updateMenuItemByObject] Menu item not updated by object because an exception occurred: ');
			Log::channel('menu')->error($e->getMessage());

			return false;
		}
	}

	/**
	 * Get plucked list of menu items without parent by title and id.
	 *
	 * @return \Illuminate\Support\Collection|boolean
	 */
	public function getPluckedListOfMenuItemsWithoutParentByTitleAndId()
	{
		try {
			return MenuItem::whereNull('parent_id')->pluck('title', 'id');
		} catch(Exception $e) {
			Log::channel('menu')->error('[MenuItemRepository:getPluckedListOfMenuItemsWithoutParentByTitleAndId] Plucked list of menu items without parent by title and id not fetched because an exception occurred: ');
			Log::channel('menu')->error($e->getMessage());

			return false;
		}
	}

	/**
	 * Get first menu item by id.
	 *
	 * @param  int  $id
	 * @return \App\Models\MenuItem|boolean
	 */
	public function getFirstMenuItemById($id)
	{
		try {
			return MenuItem::whereId($id)->first();
		} catch(Exception $e) {
			Log::channel('menu')->error('[MenuItemRepository:getFirstMenuItemById] First menu item by id not fetched because an exception occurred: ');
			Log::channel('menu')->error($e->getMessage());

			return false;
		}
	}

	/**
	 * Get first menu item without parent by sort order.
	 *
	 * @param  int  $sortOrder
	 * @return \App\Models\MenuItem|boolean
	 */
	public function getFirstMenuItemWithoutParentBySortOrder($sortOrder)
	{
		try {
			return MenuItem::whereNull('parent_id')
							 ->whereSortOrder($sortOrder)
							 ->first();
		} catch(Exception $e) {
			Log::channel('menu')->error('[MenuItemRepository:getFirstMenuItemWithoutParentBySortOrder] First menu item without parent by sort order not fetched because an exception occurred: ');
			Log::channel('menu')->error($e->getMessage());

			return false;
		}
	}

	/**
	 * Delete the menu item by object.
	 *
	 * @param  \App\Models\MenuItem  $menuItem
	 * @return boolean
	 */
	public function deleteMenuItemByObject($menuItem)
	{
		try {
			return $menuItem->delete();
		} catch (Exception $e) {
			Log::channel('menu')->error('[MenuItemRepository:deleteMenuItemByObject] Menu item not deleted by object because an exception occurred: ');
			Log::channel('menu')->error($e->getMessage());

			return false;
		}
	}

	/**
	 * Get menu items without parent where sort order is greater than the provided one
	 *
	 * @param  int  $sortOrder
	 * @return \Illuminate\Database\Eloquent\Collection|boolean
	 */
	public function getMenuItemsWithoutParentWhereSortOrderGreaterThan($sortOrder)
	{
		try {
			return MenuItem::whereNull('parent_id')
							 ->where('sort_order', '>', $sortOrder)
							 ->get();
		} catch(Exception $e) {
			Log::channel('menu')->error('[MenuItemRepository:getMenuItemsWithoutParentWhereSortOrderGreaterThan] Menu items without parent greater than provided sort order not fetched because an exception occurred: ');
			Log::channel('menu')->error($e->getMessage());

			return false;
		}
	}
}