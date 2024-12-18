<?php

namespace App\Repositories;

// Model for the repository
use App\Models\CourseTest;

// Support Facades
use Illuminate\Support\Facades\Log;

// Exception
use Exception;

class CourseTestRepository extends BaseRepository
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
	 * Create a new course test by course object.
	 *
	 * @param  array  $input
	 * @param  \App\Models\Course  $course
	 * @return \App\Models\CourseTest|boolean
	 */
	public function createCourseTestByCourseObject($input, $course)
	{
		try {
			$newCourseTest = new CourseTest($input);

			return $course->test()->save($newCourseTest);
		} catch (Exception $e) {
			Log::channel('course')->error('[CourseTestRepository:createCourseTestByCourseObject] New course test not created by course object because an exception occurred: ');
			Log::channel('course')->error($e->getMessage());

			return false;
		}
	}

	/**
	 * Update the course test by object.
	 *
	 * @param  array  $update
	 * @param  \App\Models\CourseTest  $courseTest
	 * @return boolean
	 */
	public function updateCourseTestByObject($update, $courseTest)
	{
		try {
			return $courseTest->update($update);
		} catch (Exception $e) {
			Log::channel('course')->error('[CourseTestRepository:updateCourseTestByObject] Course test not updated by object because an exception occurred: ');
			Log::channel('course')->error($e->getMessage());

			return false;
		}
	}
}