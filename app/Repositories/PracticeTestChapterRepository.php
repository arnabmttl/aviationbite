<?php

namespace App\Repositories;

// Model for the repository
use App\Models\PracticeTestChapter;

// Support Facades
use Illuminate\Support\Facades\Log;

// Exception
use Exception;

class PracticeTestChapterRepository extends BaseRepository
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
	 * Create a new practice test chapter.
	 *
	 * @param  array  $input
	 * @param  \App\Models\PracticeTest  $practiceTest
	 * @return \App\Models\PracticeTestChapter|boolean
	 */
	public function createPracticeTestChapterByPracticeTestObject($input, $practiceTest)
	{
		try {
			$newPracticeTestChapter = new PracticeTestChapter($input);

			return $practiceTest->chapters()->save($newPracticeTestChapter);
		} catch (Exception $e) {
			Log::channel('test')->error('[PracticeTestChapterRepository:createPracticeTestChapterByPracticeTestObject] New practice test chapter not created by practice test object because an exception occurred: ');
			Log::channel('test')->error($e->getMessage());

			return false;
		}
	}
}