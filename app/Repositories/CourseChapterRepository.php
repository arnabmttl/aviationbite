<?php

namespace App\Repositories;

// Model for the repository
use App\Models\CourseChapter;

// Support Facades
use Illuminate\Support\Facades\Log;

// Exception
use Exception;

class CourseChapterRepository extends BaseRepository
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
	 * Create a new CourseChapter.
	 *
	 * @param  array  $input
	 * @return \App\Models\CourseChapter
	 */
	public function createCourseChapter($input)
	{
		return CourseChapter::create($input);
	}

	/**
	 * Update the CourseChapter by the object.
	 *
	 * @param  array  $update
	 * @param  \App\Models\CourseChapter  $coursechapter
	 * @return boolean
	 */
	public function updateCourseChapterByObject($update, $chapter)
	{
		try
		{
			return $chapter->update($update);
		}
		catch (Exception $e) 
		{
			Log::channel('chapter')->error('[CourseChapterRepository:updateCourseChapterByObject] Chapter not updated by object because an exception occurred: ');
			Log::channel('chapter')->error($e->getMessage());

			return false;
		}
	}

	/**
     * Get the first course chapter by the name.
     *
     * @param  string  $name
     * @return \App\Models\CourseChapter|boolean
     */
    public function getFirstCourseChapterByName($name)
    {
        try {
            return CourseChapter::whereName($name)->first();
        } catch (Exception $e) {
            Log::channel('chapter')->error('[CourseChapterRepository:getFirstCourseChapterByName] First course chapter by name not fetched because an exception occured: ');
            Log::channel('chapter')->error($e->getMessage());

            return false;
        }
    }

    /**
     * Get the first course chapter by the name and course id.
     *
     * @param  string  $name
     * @param  int  $courseId
     * @return \App\Models\CourseChapter|boolean
     */
    public function getFirstCourseChapterByNameAndCourseId($name, $courseId)
    {
        try {
            return CourseChapter::whereName($name)->whereCourseId($courseId)->first();
        } catch (Exception $e) {
            Log::channel('chapter')->error('[CourseChapterRepository:getFirstCourseChapterByNameAndCourseId] First course chapter by name and course id not fetched because an exception occured: ');
            Log::channel('chapter')->error($e->getMessage());

            return false;
        }
    }
}