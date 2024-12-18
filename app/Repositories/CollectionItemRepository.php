<?php

namespace App\Repositories;

// Model for this repository
use App\Models\CollectionItem;

// Support Facades
use Illuminate\Support\Facades\Log;

// Exception
use Exception;

class CollectionItemRepository extends BaseRepository
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
     * Create collection item by collection and collectable object.
     *
     * @param  \App\Models\Collection  $collectionObject
     * @param  mixed  $collectableObject
     * @return \App\Models\CollectionItem|boolean
     */
    public function createCollectionItemByCollectionAndCollectableObject($collectionObject, $collectableObject)
	{
		try {
			$newCollectionItem = new CollectionItem([
									'collection_id' => $collectionObject->id,
									'sort_order' => $collectionObject->items->count()+1
								]);

			return $collectableObject->collectionItems()->save($newCollectionItem);
		} catch (Exception $e) {
			Log::channel('collection')->error('[CollectionItemRepository:createCollectionItemByCollectionAndCollectableObject] New collection item not created by collection and collectable object because an exception occurred: ');
			Log::channel('collection')->error($e->getMessage());

			return false;
		}
	}

	/**
	 * Update the collection item by object.
	 *
	 * @param  array  $update
	 * @param  \App\Models\CollectionItem  $item
	 * @return boolean
	 */
	public function updateCollectionItemByObject($update, $item)
	{
		try {
			return $item->update($update);
		} catch (Exception $e) {
			Log::channel('collection')->error('[CollectionItemRepository:updateCollectionItemByObject] Collection item not updated by object because an exception occurred: ');
			Log::channel('collection')->error($e->getMessage());

			return false;
		}
	}

	/**
	 * Delete the collection item by object.
	 *
	 * @param  \App\Models\CollectionItem  $item
	 * @return boolean
	 */
	public function deleteCollectionItemByObject($item)
	{
		try {
			return $item->delete();
		} catch (Exception $e) {
			Log::channel('collection')->error('[CollectionItemRepository:deleteCollectionItemByObject] Collection item not deleted by object because an exception occurred: ');
			Log::channel('collection')->error($e->getMessage());

			return false;
		}
	}
}