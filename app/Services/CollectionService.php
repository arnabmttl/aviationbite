<?php

namespace App\Services;

// Services
use App\Services\CourseService;

// Repositories
use App\Repositories\CollectionRepository;
use App\Repositories\CollectionItemRepository;

// Support Facades
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

// Exception
use Exception;

class CollectionService extends BaseService
{
	/**
	 * CollectionRepository instance to use various functions of CollectionRepository.
	 *
	 * @var \App\Repositories\CollectionRepository
	 */
	protected $collectionRepository;

    /**
     * CollectionItemRepository instance to use various functions of CollectionItemRepository.
     *
     * @var \App\Repositories\CollectionItemRepository
     */
    protected $collectionItemRepository;

	/**
	 * Create a new service instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();
        $this->collectionRepository = new CollectionRepository;
		$this->collectionItemRepository = new CollectionItemRepository;
	}

    /**
     * Create a new collection.
     *
     * @param  array  $input
     * @return \App\Models\Collection|boolean
     */
    public function createCollection($input)
    {
        try {
            return $this->collectionRepository->createCollection($input);
        } catch (Exception $e) {
            Log::channel('collection')->error('[CollectionService:createCollection] New collection not created because an exception occurred: ');
            Log::channel('collection')->error($e->getMessage());

            return false;
        }
    }

    /**
     * Create collection item by collection and collectable object.
     *
     * @param  \App\Models\Collection  $collectionObject
     * @param  mixed  $collectableObject
     * @return \App\Models\CollectionItem|boolean
     */
    public function createCollectionItemByCollectionAndCollectableObject($collectionObject, $collectableObject)
    {
        try {
            return $this->collectionItemRepository->createCollectionItemByCollectionAndCollectableObject($collectionObject, $collectableObject);
        } catch (Exception $e) {
            Log::channel('collection')->error('[CollectionService:createCollectionItemByCollectionAndCollectableObject] New collection item not created by collection and collectable object because an exception occurred: ');
            Log::channel('collection')->error($e->getMessage());

            return false;
        }
    }

    /**
     * Move the collection item up by object.
     *
     * @param  \App\Models\CollectionItem  $item
     * @return boolean
     */
    public function moveCollectionItemUpByObject($item)
    {
        try {
            /**
             * Sort order can be changed only if it is greater than 1.
             */
            if ($item->sort_order > 1) {
                $newSortOrder = $item->sort_order - 1;
                
                return $this->changeSortOrderByObject($newSortOrder, $item);
            }

            return false;
        } catch (Exception $e) {
            Log::channel('collection')->error('[CollectionService:moveCollectionItemUpByObject] Collection item not moved up by object because an exception occurred: ');
            Log::channel('collection')->error($e->getMessage());

            return false;
        }
    }

    /**
     * Move the collection item down by object.
     *
     * @param  \App\Models\CollectionItem  $item
     * @return boolean
     */
    public function moveCollectionItemDownByObject($item)
    {
        try {
            /**
             * Sort order can be changed only if it is not the last collection item.
             */
            if ($item->sort_order < $item->collection->items->count()) {
                $newSortOrder = $item->sort_order + 1;
                
                return $this->changeSortOrderByObject($newSortOrder, $item);
            }

            return false;
        } catch (Exception $e) {
            Log::channel('collection')->error('[CollectionService:moveCollectionItemDownByObject] Collection item not moved down by object because an exception occurred: ');
            Log::channel('collection')->error($e->getMessage());

            return false;
        }
    }

    /**
     * Change sort order for a collection item by object.
     *
     * @param  int  $newSortOrder
     * @param  \App\Models\CollectionItem  $item
     */
    public function changeSortOrderByObject($newSortOrder, $item)
    {
        try {
            $result = true;

            /**
             * Check of any collection item exist with the new sort order or not.
             * If so then replace the sort orders for both collection items.
             */
            if ($anotherCollectionItem = $item->collection->items()->whereSortOrder($newSortOrder)->first()) {
                $update['sort_order'] = $item->sort_order;
                $result = $result && $this->collectionItemRepository->updateCollectionItemByObject($update, $anotherCollectionItem);

                $update['sort_order'] = $newSortOrder;
                $result = $result && $this->collectionItemRepository->updateCollectionItemByObject($update, $item);
            } else {
                $update['sort_order'] = $newSortOrder;
                $result = $result && $this->collectionItemRepository->updateCollectionItemByObject($update, $item);
            }

            return $result;
        } catch (Exception $e) {
            Log::channel('collection')->error('[CollectionService:changeSortOrderByObject] Sort order not changed by object because an exception occurred: ');
            Log::channel('collection')->error($e->getMessage());

            return false;
        }
    }

    /**
     * Delete collection item by object.
     *
     * @param  \App\Models\CollectionItem  $item
     * @return boolean
     */
    public function deleteCollectionItemByObject($item)
    {
        try {
            /**
             * Change sort order of other items before deleting the item.
             */
            $sortOrder = $item->sort_order;
            $result = true;
            foreach ($item->collection->items->where('sort_order', '>', $item->sort_order) as $collectionItem) {
                $update['sort_order'] = $sortOrder++;
                $result = $result && $this->collectionItemRepository->updateCollectionItemByObject($update, $collectionItem);
            }

            /**
             * If collection item to be deleted is of the type TestReason.
             * Then delete the test reason as well as image and remove image from storage.
             */
            switch ($item->collectable_type) {
                case 'App\Models\Image':
                    /**
                     * Get the desktop banner image.
                     * Delete the mobile image associated with the banner.
                     * Delete the desktop banner image.
                     */
                    $desktopBanner = $item->collectable;
                    $desktopBanner->image->delete();
                    $desktopBanner->delete();
                    
                    break;
            }

            if ($result)
                return $this->collectionItemRepository->deleteCollectionItemByObject($item);
            else 
                return false;
        } catch (Exception $e) {
            Log::channel('collection')->error('[CollectionService:deleteCollectionItemByObject] Collection item not deleted by object because an exception occurred: ');
            Log::channel('collection')->error($e->getMessage());

            return false;
        }
    }

    /**
     * Get paginated list of collections.
     *
     * @param  int  $perPage
     * @return \Illuminate\Pagination\LengthAwarePaginator|boolean
     */
    public function getPaginatedListOfCollections($perPage)
    {
        try {
            return $this->collectionRepository->getPaginatedListOfNonSubSectionCollections($perPage);
        } catch (Exception $e) {
            Log::channel('collection')->error('[CollectionService:getPaginatedListOfCollections] Paginated list of collections not fetched because an exception occurred: ');
            Log::channel('collection')->error($e->getMessage());

            return false;
        }
    }

    /**
     * Create a new collection with item.
     *
     * @param  array  $input
     * @return \App\Models\Collection|boolean
     */
    public function createCollectionWithItem($input)
    {
        try {
            /**
             * Separate out the name for creating collection.
             */
            $collectionInput['name'] = $input['name'];

            if ($newCollection = $this->createCollection($collectionInput)) {
                /**
                 * Get the item object based on the type of item.
                 */
                switch ($input['type']) {
                    case 'course':
                        $item = (new CourseService)->getFirstCourseById($input['item_id']);
                        break;
                    
                    default: return false;
                }

                if ($item) {
                    if ($this->createCollectionItemByCollectionAndCollectableObject($newCollection, $item))
                        return $newCollection;
                    else {
                        /**
                         * Delete the newly created collection.
                         */
                        $this->deleteCollectionByObject($newCollection);
                        return false;
                    }
                } else {
                    Log::channel('collection')->error('[CollectionService:createCollectionWithItem] Collection with Item not created because item not found.');

                    return false;
                }
            }

            return false;
        } catch (Exception $e) {
            Log::channel('collection')->error('[CollectionService:createCollectionWithItem] Collection not created with item because an exception occurred: ');
            Log::channel('collection')->error($e->getMessage());

            return false;
        }
    }

    /**
     * Delete collection by object.
     *
     * @param  \App\Models\Collection  $collection
     * @return boolean
     */
    public function deleteCollectionByObject($collection)
    {
        try {
            return $this->collectionRepository->deleteCollectionByObject($collection);
        } catch (Exception $e) {
            Log::channel('collection')->error('[CollectionService:deleteCollectionByObject] Collection not deleted by object because an exception occurred: ');
            Log::channel('collection')->error($e->getMessage());

            return false;
        }
    }

    /**
     * Create collection item by collection object.
     *
     * @param  array  $input
     * @param  \App\Models\Collection  $collection
     * @return boolean
     */
    public function createItemByCollectionObject($input, $collection)
    {
        try {
            switch ($collection->items->first()->collectable_type) {
                case 'App\Models\Course':
                    $item = (new CourseService)->getFirstCourseById($input['item_id']);
                    break;
                
                default: return false;
            }

            return $this->createCollectionItemByCollectionAndCollectableObject($collection, $item);
        } catch (Exception $e) {
            Log::channel('collection')->error('[CollectionService:createItemByCollectionObject] Item not created by collection object because an exception occurred: ');
            Log::channel('collection')->error($e->getMessage());

            return false;
        }
    }

    /**
     * Update collection by object.
     *
     * @param  array  $update
     * @param  \App\Models\Collection  $collection
     * @return boolean
     */
    public function updateCollectionByObject($update, $collection)
    {
        try {
            return $this->collectionRepository->updateCollectionByObject($update, $collection);
        } catch (Exception $e) {
            Log::channel('collection')->error('[CollectionService:updateCollectionByObject] Collection not updated by object because an exception occurred: ');
            Log::channel('collection')->error($e->getMessage());

            return false;
        }
    }

    /**
     * Get plucked list of collections.
     *
     * @return \Illuminate\Support\Collection|boolean
     */
    public function getPluckedListOfCollections()
    {
        try {
            return $this->collectionRepository->getPluckedListOfNonSubSectionCollectionsByNameAndId();
        } catch (Exception $e) {
            Log::channel('collection')->error('[CollectionService:getPluckedListOfCollections] Plucked list of collections not fetched because an exception occurred: ');
            Log::channel('collection')->error($e->getMessage());

            return false;
        }
    }

    /**
     * Get first collection by id.
     *
     * @param  int  $id
     * @return \App\Models\Collection|boolean
     */
    public function getFirstCollectionById($id)
    {
        try {
            return $this->collectionRepository->getFirstCollectionById($id);
        } catch (Exception $e) {
            Log::channel('collection')->error('[CollectionService:getFirstCollectionById] First collection not fetched by id because an exception occurred: ');
            Log::channel('collection')->error($e->getMessage());

            return false;
        }
    }
}