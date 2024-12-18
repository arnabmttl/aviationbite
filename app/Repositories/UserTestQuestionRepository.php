<?php

namespace App\Repositories;

// Model for the repository
use App\Models\UserTestQuestion;

// Support Facades
use Illuminate\Support\Facades\Log;

// Exception
use Exception;

// Eloquent Builder
use Illuminate\Database\Eloquent\Builder;

class UserTestQuestionRepository extends BaseRepository
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
	 * Create a new user test question.
	 *
	 * @param  array  $input
	 * @param  \App\Models\UserTest  $userTest
	 * @return \App\Models\UserTestQuestion|boolean
	 */
	public function createUserTestQuestionByUserTestObject($input, $userTest)
	{
		try {
			$newUserTestQuestion = new UserTestQuestion($input);

			return $userTest->questions()->save($newUserTestQuestion);
		} catch (Exception $e) {
			Log::channel('test')->error('[UserTestQuestionRepository:createUserTestQuestionByUserTestObject] New user test question not created by user test object because an exception occurred: ');
			Log::channel('test')->error($e->getMessage());

			return false;
		}
	}

	/**
	 * Get the first user test question by id and user id.
	 *
	 * @param  int  $id
	 * @param  int  $userId
	 * @return \App\Models\UserTestQuestion|boolean
	 */
	public function getFirstUserTestQuestionByIdAndUserId($id, $userId)
	{
		try {
			return UserTestQuestion::whereId($id)
								 		 ->whereHas('userTest', function(Builder $query) use ($userId) {
								 		 	$query->whereUserId($userId);
								 		 })
								 		 ->first();
		} catch (Exception $e) {
			Log::channel('test')->error('[UserTestQuestionRepository:getFirstUserTestQuestionByIdAndUserId] First user test question not fetched by id and user id because an exception occurred: ');
			Log::channel('test')->error($e->getMessage());

			return false;
		}
	}

	/**
     * Update the user test question by the object.
     *
     * @param  array  $update
     * @param  \App\Models\UserTestQuestion  $userTestQuestion
     * @return boolean
     */
    public function updateUserTestQuestionByObject($update, $userTestQuestion)
    {
    	try {
    		return $userTestQuestion->update($update);
    	} catch (Exception $e) {
    		Log::channel('test')->error('[UserTestQuestionRepository:updateUserTestQuestionByObject] User test question not updated by object because an exception occurred: ');
    		Log::channel('test')->error($e->getMessage());

    		return false;
    	}
    }
}