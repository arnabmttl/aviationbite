<?php

namespace App\Repositories;

// Model for the repository
use App\Models\Topic;

// Support Facades
use Illuminate\Support\Facades\Log;

// Exception
use Exception;

class TopicRepository extends BaseRepository
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
	 * Get the paginated list of topics ordered by updated at.
	 *
	 * @param  int  $perPage
	 * @return \Illuminate\Pagination\LengthAwarePaginator|boolean
	 */
	public function getPaginatedListOfTopicsOrderedByUpdatedAt($perPage)
	{
		try {
			return Topic::orderBy('updated_at', 'desc')->paginate($perPage);
		} catch (Exception $e) {
			Log::channel('topic')->error('[TopicRepository:getPaginatedListOfTopicsOrderedByUpdatedAt] Paginated list of topics ordered by updated at not fetched because an exception occurred: ');
			Log::channel('topic')->error($e->getMessage());

			return false;
		}
	}

	/**
	 * Get the plucked list of topics by name and id.
	 *
	 * @return \Illuminate\Support\Collection|boolean
	 */
	public function getPluckedListOfTopicsByNameAndId()
	{
		try {
			return Topic::pluck('name', 'id');
		} catch (Exception $e) {
			Log::channel('topic')->error('[TopicRepository:getPluckedListOfTopicsByNameAndId] Plucked list of topics by name and id not fetched because an exception occurred: ');
			Log::channel('topic')->error($e->getMessage());

			return false;
		}
	}

	/**
	 * Create a new topic.
	 *
	 * @param  array  $input
	 * @return \App\Models\Topic|boolean
	 */
	public function createTopic($input)
	{
		try {
			return Topic::create($input);
		} catch (Exception $e) {
			Log::channel('topic')->error('[TopicRepository:createTopic] New topic not created because an exception occurred: ');
			Log::channel('topic')->error($e->getMessage());

			return false;
		}
	}

	/**
	 * Update the topic by the object.
	 *
	 * @param  array  $update
	 * @param  \App\Models\Topic  $topic
	 * @return boolean
	 */
	public function updateTopicByObject($update, $topic)
	{
		try {
			return $topic->update($update);
		} catch (Exception $e) {
			Log::channel('topic')->error('[TopicRepository:updateTopicByObject] Topic not updated by object because an exception occurred: ');
			Log::channel('topic')->error($e->getMessage());

			return false;
		}
	}

	/**
	 * Delete the topic by the object.
	 *
	 * @param  \App\Models\Topic  $topic
	 * @return boolean
	 */
	public function deleteTopicByObject($topic)
	{
		try {
			return $topic->delete();
		} catch (Exception $e) {
			Log::channel('topic')->error('[TopicRepository:deleteTopicByObject] Topic not deleted by object because an exception occurred: ');
			Log::channel('topic')->error($e->getMessage());

			return false;
		}
	}

	/**
     * Get the first topic by the name.
     *
     * @param  string  $name
     * @return \App\Models\Topic|boolean
     */
    public function getFirstTopicByName($name)
    {
        try {
            return Topic::whereName($name)->first();
        } catch (Exception $e) {
            Log::channel('topic')->error('[TopicRepository:getFirstTopicByName] First topic by name not fetched because an exception occured: ');
            Log::channel('topic')->error($e->getMessage());

            return false;
        }
    }
}