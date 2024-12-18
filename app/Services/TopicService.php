<?php

namespace App\Services;

// Repositories
use App\Repositories\TopicRepository;

// Support Facades
use Illuminate\Support\Facades\Log;

// Exception
use Exception;

class TopicService extends BaseService
{
	/**
	 * TopicRepository instance to use various functions of TopicRepository.
	 *
	 * @var \App\Repositories\TopicRepository
	 */
	protected $topicRepository;

	/**
	 * Create a new service instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();
		$this->topicRepository = new TopicRepository;
	}

	/**
	 * Get the paginated list of topics by updated at.
	 *
	 * @param  int  $perPage
	 * @return \Illuminate\Pagination\LengthAwarePaginator|boolean
	 */
	public function getPaginatedListOfTopicsOrderedByUpdatedAt($perPage)
	{
		return $this->topicRepository->getPaginatedListOfTopicsOrderedByUpdatedAt($perPage);
	}

	/**
	 * Get the plucked list of topics by name and id.
	 *
	 * @return \Illuminate\Support\Collection|boolean
	 */
	public function getPluckedListOfTopicsByNameAndId()
	{
		return $this->topicRepository->getPluckedListOfTopicsByNameAndId();
	}

	/**
	 * Create a new topic.
	 *
	 * @param  array  $input
	 * @return \App\Models\Topic|boolean
	 */
	public function createTopic($input)
	{
		return $this->topicRepository->createTopic($input);
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
		return $this->topicRepository->updateTopicByObject($update, $topic);
	}

	/**
	 * Delete the topic by the object.
	 *
	 * @param  \App\Models\Topic  $topic
	 * @return boolean
	 */
	public function deleteTopicByObject($topic)
	{
		return $this->topicRepository->deleteTopicByObject($topic);
	}

	/**
     * Get the first topic by the name.
     *
     * @param  string  $name
     * @return \App\Models\Topic|boolean
     */
    public function getFirstTopicByName($name)
    {
        return $this->topicRepository->getFirstTopicByName($name);
    }

    /**
     * Get the topic ids from the commas separated topic names.
     *
     * @param  string  $topicNames
     * @return array<int, int>|boolean
     */
    public function getTopicIdsFromCommaSeparatedTopicNames($topicNames)
    {
        try {
			/**
	         * Separate the topic names (comma separated) coming in the array.
	         * Check for each topic name, whether it exists or not.
	         * IF exists then hold its id in the array.
	         * ELSE create new topic and hold its id in the array.
	         */
	        $topicIds = array();
	        $topicNames = explode(',', $topicNames);
	        $result = true;
	        foreach ($topicNames as $topicName) {
	            if ($trimmedTopicName = trim($topicName)) {
	                if (!($topic = $this->getFirstTopicByName($trimmedTopicName)))
	                	$topic = $this->createTopic(['name' => $trimmedTopicName]);

	                $result = $result && $topic;
	                $topicIds[] = $topic->id;
	            }
	        }

	        if ($result)
	        	return $topicIds;
	        else
	        	return false;
		} catch (Exception $e) {
			Log::channel('topic')->error('[TopicService:getTopicIdsFromCommaSeparatedTopicNames] Topic ids not fetched from comma separated topic names because an exception occurred: ');
			Log::channel('topic')->error($e->getMessage());

			return false;
		}
    }
}