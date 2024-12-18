<?php

namespace App\Services;

// Repositories
use App\Repositories\MenuItemRepository;

// Support Facades
use Illuminate\Support\Facades\Log;

// Exception
use Exception;

class MenuItemService extends BaseService
{
	/**
	 * MenuItemRepository instance to use various functions of MenuItemRepository.
	 *
	 * @var \App\Repositories\MenuItemRepository
	 */
	protected $menuItemRepository;

	/**
	 * Create a new service instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();
		$this->menuItemRepository = new MenuItemRepository;
	}

    /**
     * Get all menu items available without parent.
     *
     * @return \Illuminate\Database\Eloquent\Collection|boolean
     */
    public function getAllMenuItemsWithoutParent()
    {
        try {
            return $this->menuItemRepository->getAllMenuItemsWithoutParent();
        } catch(Exception $e) {
            Log::channel('menu')->error('[MenuItemService:getAllMenuItemsWithoutParent] All menu items without parent not fetched because an exception occurred: ');
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
            return $this->menuItemRepository->getPluckedListOfMenuItemsWithoutParentByTitleAndId();
        } catch(Exception $e) {
            Log::channel('menu')->error('[MenuItemService:getPluckedListOfMenuItemsWithoutParentByTitleAndId] Plucked list of menu items without parent by title and id not fetched because an exception occurred: ');
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
            /**
             * If parent is selected then sort order will be calculated based on the parent.
             * Else sort order will be calculated based on the menu items without parents.
             */
            if (isset($input['parent_id'])) {
                $parentMenuItem = $this->menuItemRepository->getFirstMenuItemById($input['parent_id']);

                $input['sort_order'] = $parentMenuItem->children->count() + 1;
            } else {
                $input['sort_order'] = $this->menuItemRepository->getAllMenuItemsWithoutParent()->count() + 1;
            }

            return $this->menuItemRepository->createMenuItem($input);
        } catch (Exception $e) {
            Log::channel('menu')->error('[MenuItemService:createMenuItem] New menu item not created because an exception occurred: ');
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
            return $this->menuItemRepository->updateMenuItemByObject($update, $menuItem);
        } catch (Exception $e) {
            Log::channel('menu')->error('[MenuItemService:updateMenuItemByObject] Menu item not updated by object because an exception occurred: ');
            Log::channel('menu')->error($e->getMessage());

            return false;
        }
    }

    /**
     * Move the menu item up by object.
     *
     * @param  \App\Models\MenuItem  $menuItem
     * @return boolean
     */
    public function moveMenuItemUpByObject($menuItem)
    {
        try {
            /**
             * Sort order can be changed only if it is greater than 1.
             */
            if ($menuItem->sort_order > 1) {
                $newSortOrder = $menuItem->sort_order - 1;
                
                return $this->changeSortOrderByObject($newSortOrder, $menuItem);
            }

            return false;
        } catch (Exception $e) {
            Log::channel('menu')->error('[MenuItemService:moveMenuItemUpByObject] Menu item not moved up by object because an exception occurred: ');
            Log::channel('menu')->error($e->getMessage());

            return false;
        }
    }

    /**
     * Move the menu item down by object.
     *
     * @param  \App\Models\MenuItem  $menuItem
     * @return boolean
     */
    public function moveMenuItemDownByObject($menuItem)
    {
        try {
            /**
             * Sort order can be changed only if it is not the last menu item.
             * If it is a child menu item then last menu item depends on the parent.
             * Else last menu item will depend on the menu items without parent.
             */
            if ($menuItem->parent) {
                if ($menuItem->sort_order < $menuItem->parent->children->count()) {
                    $newSortOrder = $menuItem->sort_order + 1;
                    
                    return $this->changeSortOrderByObject($newSortOrder, $menuItem);
                }
            } else {
                if ($menuItem->sort_order < $this->menuItemRepository->getAllMenuItemsWithoutParent()->count()) {
                    $newSortOrder = $menuItem->sort_order + 1;
                    
                    return $this->changeSortOrderByObject($newSortOrder, $menuItem);
                }
            }

            return false;
        } catch (Exception $e) {
            Log::channel('menu')->error('[MenuItemService:moveMenuItemDownByObject] Menu item not moved down by object because an exception occurred: ');
            Log::channel('menu')->error($e->getMessage());

            return false;
        }
    }

    /**
     * Change sort order for a menu item by object.
     *
     * @param  int  $newSortOrder
     * @param  \App\Models\MenuItem  $menuItem
     */
    public function changeSortOrderByObject($newSortOrder, $menuItem)
    {
        try {
            $result = true;

            /**
             * Check of any menu item exist with the new sort order or not.
             * If so then replace the sort orders for both menu items
             * Depeding on same parent or items without parent.
             */
            if ($menuItem->parent) {
                if ($anotherMenuItem = $menuItem->parent->children()->whereSortOrder($newSortOrder)->first()) {
                    $update['sort_order'] = $menuItem->sort_order;
                    $result = $result && $this->menuItemRepository->updateMenuItemByObject($update, $anotherMenuItem);

                    $update['sort_order'] = $newSortOrder;
                    $result = $result && $this->menuItemRepository->updateMenuItemByObject($update, $menuItem);
                } else {
                    $update['sort_order'] = $newSortOrder;
                    $result = $result && $this->menuItemRepository->updateMenuItemByObject($update, $menuItem);
                }
            } else {
                if ($anotherMenuItem = $this->menuItemRepository->getFirstMenuItemWithoutParentBySortOrder($newSortOrder)) {
                    $update['sort_order'] = $menuItem->sort_order;
                    $result = $result && $this->menuItemRepository->updateMenuItemByObject($update, $anotherMenuItem);

                    $update['sort_order'] = $newSortOrder;
                    $result = $result && $this->menuItemRepository->updateMenuItemByObject($update, $menuItem);
                } else {
                    $update['sort_order'] = $newSortOrder;
                    $result = $result && $this->menuItemRepository->updateMenuItemByObject($update, $menuItem);
                }
            }

            return $result;
        } catch (Exception $e) {
            Log::channel('menu')->error('[MenuItemService:changeSortOrderByObject] Sort order not changed by object because an exception occurred: ');
            Log::channel('menu')->error($e->getMessage());

            return false;
        }
    }

    /**
     * Delete menu item by object.
     *
     * @param  \App\Models\MenuItem  $menuItem
     * @return boolean
     */
    public function deleteMenuItemByObject($menuItem)
    {
        try {
            /**
             * Change sort order of other menu items before deleting the menu item.
             */
            $sortOrder = $menuItem->sort_order;

            if ($menuItem->parent) {
                foreach ($menuItem->parent->children->where('sort_order', '>', $menuItem->sort_order) as $otherMenuItem) {
                    $update['sort_order'] = $sortOrder++;
                    $this->menuItemRepository->updateMenuItemByObject($update, $otherMenuItem);
                }
            } else {
                foreach ($this->menuItemRepository->getMenuItemsWithoutParentWhereSortOrderGreaterThan($menuItem->sort_order) as $otherMenuItem) {
                    $update['sort_order'] = $sortOrder++;
                    $this->menuItemRepository->updateMenuItemByObject($update, $otherMenuItem);
                }
            }

            return $this->menuItemRepository->deleteMenuItemByObject($menuItem);
        } catch (Exception $e) {
            Log::channel('menu')->error('[MenuItemService:deleteMenuItemByObject] MEnu item not deleted by object because an exception occurred: ');
            Log::channel('menu')->error($e->getMessage());

            return false;
        }
    }
}