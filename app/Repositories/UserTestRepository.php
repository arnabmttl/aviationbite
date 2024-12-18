<?php

namespace App\Repositories;

// Model for the repository
use App\Models\UserTest;

// Support Facades
use Illuminate\Support\Facades\Log;

// Exception
use Exception;

class UserTestRepository extends BaseRepository
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
	 * Create a new user test.
	 *
	 * @param  array  $input
	 * @param  \App\Models\User  $user
	 * @return \App\Models\UserTest|boolean
	 */
	public function createUserTestByUserObject($input, $user)
	{
		try {
			$newUserTest = new UserTest($input);

			return $user->userTests()->save($newUserTest);
		} catch (Exception $e) {
			Log::channel('test')->error('[UserTestRepository:createUserTestByUserObject] New user test not created by user object because an exception occurred: ');
			Log::channel('test')->error($e->getMessage());

			return false;
		}
	}

	/**
	 * Get the first user test by id and user id.
	 *
	 * @param  int  $id
	 * @param  int  $userId
	 * @return \App\Models\UserTest|boolean
	 */
	public function getFirstUserTestByIdAndUserId($id, $userId)
	{
		try {
			return UserTest::whereId($id)
								 ->whereUserId($userId)
								 ->first();
		} catch (Exception $e) {
			Log::channel('test')->error('[UserTestRepository:getFirstUserTestByIdAndUserId] First user test not fetched by id and user id because an exception occurred: ');
			Log::channel('test')->error($e->getMessage());

			return false;
		}
	}

	/**
     * Update the user test by the object.
     *
     * @param  array  $update
     * @param  \App\Models\UserTest  $userTest
     * @return boolean
     */
    public function updateUserTestByObject($update, $userTest)
    {
    	try {
    		return $userTest->update($update);
    	} catch (Exception $e) {
    		Log::channel('test')->error('[UserTestRepository:updateUserTestByObject] User test not updated by object because an exception occurred: ');
    		Log::channel('test')->error($e->getMessage());

    		return false;
    	}
    }
}