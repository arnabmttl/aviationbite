<?php

namespace App\Repositories;

// Model for the repository
use App\Models\CourseTestChapter;

// Support Facades
use Illuminate\Support\Facades\Log;

// Exception
use Exception;

class CourseTestChapterRepository extends BaseRepository
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
	 * Create a new course test chapter by course test object.
	 *
	 * @param  array  $input
	 * @param  \App\Models\CourseTest  $courseTest
	 * @return \App\Models\CourseTestChapter|boolean
	 */
	public function createCourseTestChapterByCourseTestObject($input, $courseTest)
	{
		try {
			$newCourseTestChapter = new CourseTestChapter($input);

			return $courseTest->chapters()->save($newCourseTestChapter);
		} catch (Exception $e) {
			Log::channel('course')->error('[CourseTestChapterRepository:createCourseTestChapterByCourseTestObject] New course test chapter not created by course test object because an exception occurred: ');
			Log::channel('course')->error($e->getMessage());

			return false;
		}
	}

	/**
	 * Update the course test chapter by object.
	 *
	 * @param  array  $update
	 * @param  \App\Models\CourseTestChapter  $courseTestChapter
	 * @return boolean
	 */
	public function updateCourseTestChapterByObject($update, $courseTestChapter)
	{
		try {
			return $courseTestChapter->update($update);
		} catch (Exception $e) {
			Log::channel('course')->error('[CourseTestChapterRepository:updateCourseTestChapterByObject] Course test chapter not updated by object because an exception occurred: ');
			Log::channel('course')->error($e->getMessage());

			return false;
		}
	}
}