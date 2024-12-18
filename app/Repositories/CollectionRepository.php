<?php

namespace App\Repositories;

// Model for this repository
use App\Models\Collection;

// Support Facades
use Illuminate\Support\Facades\Log;

// Exception
use Exception;

class CollectionRepository extends BaseRepository
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
	 * Create a new collection.
	 *
	 * @param  array  $input
	 * @return \App\Models\Collection|boolean
	 */
	public function createCollection($input)
	{
		try {
			return Collection::create($input);
		} catch (Exception $e) {
			Log::channel('collection')->error('[CollectionRepository:createCollection] New collection not created because an exception occurred: ');
			Log::channel('collection')->error($e->getMessage());

			return false;
		}
	}

	/**
	 * Get paginated list of collections that are not sub section.
	 *
	 * @param  int  $perPage
	 * @return \Illuminate\Pagination\LengthAwarePaginator|boolean
	 */
	public function getPaginatedListOfNonSubSectionCollections($perPage)
	{
		try {
			return Collection::whereIsSubSection(0)->paginate($perPage);
		} catch (Exception $e) {
			Log::channel('collection')->error('[CollectionRepository:getPaginatedListOfNonSubSectionCollections] Paginated list of collections that are not sub section not fetched because an exception occurred: ');
			Log::channel('collection')->error($e->getMessage());

			return false;
		}
	}

	/**
	 * Delete the collection by object.
	 *
	 * @param  \App\Models\Collection  $collection
	 * @return boolean
	 */
	public function deleteCollectionByObject($collection)
	{
		try {
			return $collection->delete();
		} catch (Exception $e) {
			Log::channel('collection')->error('[CollectionRepository:deleteCollectionByObject] Collection not deleted by object because an exception occurred: ');
			Log::channel('collection')->error($e->getMessage());

			return false;
		}
	}

	/**
	 * Update the collection by object.
	 *
	 * @param  array  $update
	 * @param  \App\Models\Collection  $collection
	 * @return boolean
	 */
	public function updateCollectionByObject($update, $collection)
	{
		try {
			return $collection->update($update);
		} catch (Exception $e) {
			Log::channel('collection')->error('[CollectionRepository:updateCollectionByObject] Collection not updated by object because an exception occurred: ');
			Log::channel('collection')->error($e->getMessage());

			return false;
		}
	}

	/**
	 * Get plucked list of collections by name and id.
	 *
	 * @return \Illuminate\Support\Collection|boolean
	 */
	public function getPluckedListOfNonSubSectionCollectionsByNameAndId()
	{
		try {
			return Collection::whereIsSubSection(0)->pluck('name', 'id');
		} catch (Exception $e) {
			Log::channel('collection')->error('[CollectionRepository:getPluckedListOfCollectionsByNameAndId] Plucked list of collections by title and id not fetched because an exception occurred: ');
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
			return Collection::whereId($id)->first();
		} catch (Exception $e) {
			Log::channel('collection')->error('[CollectionRepository:getFirstCollectionById] First collection not fetched by id because an exception occurred: ');
			Log::channel('collection')->error($e->getMessage());

			return false;
		}
	}
}