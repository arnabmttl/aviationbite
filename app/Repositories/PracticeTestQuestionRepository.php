<?php

namespace App\Repositories;

// Model for the repository
use App\Models\PracticeTestQuestion;

// Support Facades
use Illuminate\Support\Facades\Log;

// Exception
use Exception;

// Eloquent Builder
use Illuminate\Database\Eloquent\Builder;

class PracticeTestQuestionRepository extends BaseRepository
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
	 * Create a new practice test question.
	 *
	 * @param  array  $input
	 * @param  \App\Models\PracticeTest  $practiceTest
	 * @return \App\Models\PracticeTestQuestion|boolean
	 */
	public function createPracticeTestQuestionByPracticeTestObject($input, $practiceTest)
	{
		try {
			$newPracticeTestQuestion = new PracticeTestQuestion($input);

			return $practiceTest->questions()->save($newPracticeTestQuestion);
		} catch (Exception $e) {
			Log::channel('test')->error('[PracticeTestQuestionRepository:createPracticeTestQuestionByPracticeTestObject] New practice test question not created by practice test object because an exception occurred: ');
			Log::channel('test')->error($e->getMessage());

			return false;
		}
	}

	/**
	 * Get the first practice test question by id and user id.
	 *
	 * @param  int  $id
	 * @param  int  $userId
	 * @return \App\Models\PracticeTestQuestion|boolean
	 */
	public function getFirstPracticeTestQuestionByIdAndUserId($id, $userId)
	{
		try {
			return PracticeTestQuestion::whereId($id)
								 		 ->whereHas('practiceTest', function(Builder $query) use ($userId) {
								 		 	$query->whereUserId($userId);
								 		 })
								 		 ->first();
		} catch (Exception $e) {
			Log::channel('test')->error('[PracticeTestQuestionRepository:getFirstPracticeTestQuestionByIdAndUserId] First practice test question not fetched by id and user id because an exception occurred: ');
			Log::channel('test')->error($e->getMessage());

			return false;
		}
	}

	/**
     * Update the practice test question by the object.
     *
     * @param  array  $update
     * @param  \App\Models\PracticeTestQuestion  $practiceTestQuestion
     * @return boolean
     */
    public function updatePracticeTestQuestionByObject($update, $practiceTestQuestion)
    {
    	try {
    		return $practiceTestQuestion->update($update);
    	} catch (Exception $e) {
    		Log::channel('test')->error('[PracticeTestQuestionRepository:updatePracticeTestQuestionByObject] Practice test question not updated by object because an exception occurred: ');
    		Log::channel('test')->error($e->getMessage());

    		return false;
    	}
    }
}