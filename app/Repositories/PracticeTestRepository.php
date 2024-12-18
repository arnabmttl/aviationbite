<?php

namespace App\Repositories;

// Model for the repository
use App\Models\PracticeTest;

// Support Facades
use Illuminate\Support\Facades\Log;

// Exception
use Exception;

class PracticeTestRepository extends BaseRepository
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
	 * Create a new practice test.
	 *
	 * @param  array  $input
	 * @param  \App\Models\User  $user
	 * @return \App\Models\PracticeTest|boolean
	 */
	public function createPracticeTestByUserObject($input, $user)
	{
		try {
			$newPracticeTest = new PracticeTest($input);

			return $user->practiceTests()->save($newPracticeTest);
		} catch (Exception $e) {
			Log::channel('test')->error('[PracticeTestRepository:createPracticeTestByUserObject] New practice test not created by user object because an exception occurred: ');
			Log::channel('test')->error($e->getMessage());

			return false;
		}
	}

	/**
	 * Get the first practice test by id and user id.
	 *
	 * @param  int  $id
	 * @param  int  $userId
	 * @return \App\Models\PracticeTest|boolean
	 */
	public function getFirstPracticeTestByIdAndUserId($id, $userId)
	{
		try {
			return PracticeTest::whereId($id)
								 ->whereUserId($userId)
								 ->first();
		} catch (Exception $e) {
			Log::channel('test')->error('[PracticeTestRepository:getFirstPracticeTestByIdAndUserId] First practice test not fetched by id and user id because an exception occurred: ');
			Log::channel('test')->error($e->getMessage());

			return false;
		}
	}

	/**
     * Update the practice test by the object.
     *
     * @param  array  $update
     * @param  \App\Models\PracticeTest  $practiceTest
     * @return boolean
     */
    public function updatePracticeTestByObject($update, $practiceTest)
    {
    	try {
    		return $practiceTest->update($update);
    	} catch (Exception $e) {
    		Log::channel('test')->error('[PracticeTestRepository:updatePracticeTestByObject] Practice test not updated by object because an exception occurred: ');
    		Log::channel('test')->error($e->getMessage());

    		return false;
    	}
    }
}