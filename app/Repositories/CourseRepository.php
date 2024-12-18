<?php

namespace App\Repositories;

// Model for the repository
use App\Models\Course;

// Support Facades
use Illuminate\Support\Facades\Log;

// Exception
use Exception;

class CourseRepository extends BaseRepository
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
	 * Create a new course.
	 *
	 * @param  array  $input
	 * @param  \App\Models\User  $user
	 * @return \App\Models\Course|boolean
	 */
	public function createCourseByUserObject($input, $user)
	{
		try {
			$newCourse = new Course($input);
			$newCourse->updated_by_id = $user->id;

			return $user->createdCourses()->save($newCourse);
		} catch (Exception $e) {
			Log::channel('course')->error('[CourseRepository:createCourseByUserObject] New course not created by user object because an exception occurred: ');
			Log::channel('course')->error($e->getMessage());

			return false;
		}
	}

	/**
	 * Delete the course by the object.
	 *
	 * @param  \App\Models\Course  $course
	 * @return boolean
	 */
	public function deleteCourseByObject($course)
	{
		try {
			return $course->delete();
		} catch (Exception $e) {
			Log::channel('course')->error('[CourseRepository:deleteCourseByObject] Course not deleted by object because an exception occurred: ');
			Log::channel('course')->error($e->getMessage());

			return false;
		}
	}

	/**
	 * Get the plucked list of courses by name and id.
	 *
	 * @return \Illuminate\Support\Collection|boolean
	 */
	public function getPluckedListOfCoursesByNameAndId()
	{
		try {
			return Course::pluck('name', 'id');
		} catch (Exception $e) {
			Log::channel('course')->error('[CourseRepository:getPluckedListOfCoursesByNameAndId] Plucked list of courses by name and id not fetched because an exception occurred: ');
			Log::channel('course')->error($e->getMessage());

			return false;
		}
	}

	/**
     * Get the first course by the id.
     *
     * @param  int  $id
     * @return \App\Models\Course|boolean
     */
    public function getFirstCourseById($id)
    {
        try {
            return Course::whereId($id)->first();
        } catch (Exception $e) {
            Log::channel('course')->error('[CourseRepository:getFirstCourseById] First course by id not fetched because an exception occured: ');
            Log::channel('course')->error($e->getMessage());

            return false;
        }
    }

    /**
     * Get the courses based on the is_active.
     *
     * @param  int  $isActive
     * @return \Illuminate\Database\Eloquent\Collection|boolean
     */
    public function getCoursesByActiveStatus($isActive)
    {
        try {
            return Course::whereIsActive($isActive)->get();
        } catch (Exception $e) {
            Log::channel('course')->error('[CourseRepository:getCoursesByActiveStatus] Courses by active status not fetched because an exception occured: ');
            Log::channel('course')->error($e->getMessage());

            return false;
        }
    }

    /**
	 * Update the course by the object.
	 *
	 * @param  array  $update
	 * @param  \App\Models\Course  $course
	 * @return boolean
	 */
	public function updateCourseByObject($update, $course)
	{
		try {
			return $course->update($update);
		} catch (Exception $e) {
			Log::channel('course')->error('[CourseRepository:updateCourseByObject] Course not updated by object because an exception occurred: ');
			Log::channel('course')->error($e->getMessage());

			return false;
		}
	}

	/**
     * Get the first course by the slug.
     *
     * @param  string  $slug
     * @return \App\Models\Course|boolean
     */
    public function getFirstCourseBySlug($slug)
    {
        try {
            return Course::whereSlug($slug)->first();
        } catch (Exception $e) {
            Log::channel('course')->error('[CourseRepository:getFirstCourseBySlug] First course by slug not fetched because an exception occured: ');
            Log::channel('course')->error($e->getMessage());

            return false;
        }
    }

    /**
     * Get the first course by the name.
     *
     * @param  string  $name
     * @return \App\Models\Course|boolean
     */
    public function getFirstCourseByName($name)
    {
        try {
            return Course::whereName($name)->first();
        } catch (Exception $e) {
            Log::channel('course')->error('[CourseRepository:getFirstCourseByName] First course by name not fetched because an exception occured: ');
            Log::channel('course')->error($e->getMessage());

            return false;
        }
    }

    /**
	 * Get the plucked list of active courses by name and id.
	 *
	 * @return \Illuminate\Support\Collection|boolean
	 */
	public function getPluckedListOfActiveCoursesByNameAndId()
	{
		try {
			return Course::whereIsActive(1)
						   ->pluck('name', 'id');
		} catch (Exception $e) {
			Log::channel('course')->error('[CourseRepository:getPluckedListOfActiveCoursesByNameAndId] Plucked list of active courses by name and id not fetched because an exception occurred: ');
			Log::channel('course')->error($e->getMessage());

			return false;
		}
	}
}