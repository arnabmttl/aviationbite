<?php

namespace App\Services;

// Models
use App\Models\Document;

// Services
use App\Services\AuthService;

// Repositories
use App\Repositories\CourseRepository;
use App\Repositories\DifficultyLevelRepository;
use App\Repositories\CourseTestRepository;
use App\Repositories\CourseTestChapterRepository;

// Imports
use App\Imports\CoursesImport;

// Laravel Excel
use Maatwebsite\Excel\Facades\Excel;

// Support Facades
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

// Exception
use Exception;

class CourseService extends BaseService
{
	/**
	 * CourseRepository instance to use various functions of CourseRepository.
	 *
	 * @var \App\Repositories\CourseRepository
	 */
	protected $courseRepository;

	/**
	 * CourseTestRepository instance to use various functions of CourseTestRepository.
	 *
	 * @var \App\Repositories\CourseTestRepository
	 */
	protected $courseTestRepository;

	/**
	 * CourseTestChapterRepository instance to use various functions of CourseTestChapterRepository.
	 *
	 * @var \App\Repositories\CourseTestChapterRepository
	 */
	protected $courseTestChapterRepository;

	/**
	 * Create a new service instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();
		$this->courseRepository = new CourseRepository;
		$this->courseTestRepository = new CourseTestRepository;
		$this->courseTestChapterRepository = new CourseTestChapterRepository;
	}

	/**
	 * Create a new course.
	 *
	 * @param  array  $input
	 * @return \App\Models\Course|boolean
	 */
	public function createCourse($input)
	{
		try {
			/**
			 * Get the currently logged in user.
			 * IF user is fetched.
			 * THEN create course using that user.
			 * ELSE log the issue.
			 */
			if ($user = (new AuthService)->getCurrentlyLoggedInUser()) {
				/**
				 * IF thumbnail image is coming with the course.
				 * THEN save the thumbnail_image in temporary variable for uploading after the course is 
	             * created. And unset the 'thumbnail_image' as that is not to be inserted in database.
	             */
				if (isset($input['thumbnail_image'])) {
					$tempThumbnailImage = $input['thumbnail_image'];
		            unset($input['thumbnail_image']);
				}

	            /**
	             * Save the topics in temporary variable for attaching with the course after creation.
	             * And unset the 'topics' as that us not to be inserted in database.
	             */
	            $tempTopics = $input['topics'];
	            unset($input['topics']);

	            /**
	             * If new course is created succesfully then do the further processing 
	             * else return false. 
	             */
	            if($newCourse = $this->courseRepository->createCourseByUserObject($input, $user)) {
	                /**
	                 * Associate topics with the newly created course.
	                 */
	                $newCourse->topics()->attach(
	                	$tempTopics,
	                	[
	                		'created_at' => now(),
	                		'updated_at' => now()
	                	]
	                );

	                /**
					 * IF thumbnail image is stored with the temporary image.
					 * THEN do the further processing.
		             */
					if (isset($tempThumbnailImage)) {
		                /**
		                 * Save thumbnail image to storage.
		                 */
		                $tempThumbnailImage = Storage::put('/public/courses/thumbnails', $tempThumbnailImage);

		                /**
		                 * Create new document and save it using the relationship.
		                 */
		                $newThumbnailImage = new Document;
		                $newThumbnailImage->document_type = 1;
		                $newThumbnailImage->type = 'Thumbnail';
		                $newThumbnailImage->url = 'courses/thumbnails/'.basename($tempThumbnailImage);

		                /**
		                 * If image file is uploaded and new entry created in table then return the
		                 * newly created course else delete the newly created article and return false.
		                 */
		                if($newCourse->documents()->save($newThumbnailImage)) {
		                    return $newCourse;
		                }
		                else {
		                    /**
		                     * Check if image is saved in storage or not. If so, then delete it.
		                     */
		                    if(Storage::exists('/public/courses/thumbnails/'.basename($tempThumbnailImage)))
		                        Storage::delete('/public/courses/thumbnails/'.basename($tempThumbnailImage));

		                    $this->deleteCourseByObject($newCourse);

		                    Log::channel('course')->error('[CourseService:createCourse] Course not added because some issue occurred in relating the course with image(s).');

		                    return false;
		                }
		            }

		            return $newCourse;
	            }
	            else
	                return false;
			} else {
				Log::channel('course')->error('[CourseService:createCourse] Course not created because either no user logged in or there is some problem in fetching the logged in user.');

				return false;
			}
		} catch (Exception $e) {
			Log::channel('course')->error('[CourseService:createCourse] Course not created because an exception occurred: ');
			Log::channel('course')->error($e->getMessage());

			return false;
		}
	}

	/**
	 * Delete course by object.
	 *
	 * @param  \App\Models\Course  $course
	 * @return boolean
	 */
	public function deleteCourseByObject($course)
	{
        /**
         * Delete image from storage before deleting the course.
         */
        if($course->thumbnail && Storage::exists('/public/'.$course->thumbnail->url))
            Storage::delete('/public/'.$course->thumbnail->url);

        /**
         * Delete file entry from the table.
         */
        $course->thumbnail->delete();

		return $this->courseRepository->deleteCourseByObject($course);
	}

	/**
	 * Get the plucked list of courses by name and id.
	 *
	 * @return \Illuminate\Support\Collection|boolean
	 */
	public function getPluckedListOfCoursesByNameAndId()
	{
		return $this->courseRepository->getPluckedListOfCoursesByNameAndId();
	}

	/**
     * Get the first course by the id.
     *
     * @param  int  $id
     * @return \App\Models\Course|boolean
     */
    public function getFirstCourseById($id)
    {
        return $this->courseRepository->getFirstCourseById($id);
    }

    /**
     * Get all the active courses available.
     *
     * @return \Illuminate\Database\Eloquent\Collection|boolean
     */
    public function getAllActiveCourses()
    {
        return $this->courseRepository->getCoursesByActiveStatus(1);
    }

    /**
     * Get the first course by the id.
     *
     * @param  \App\Models\Course  $course
     * @return array|boolean
     */
    public function getChapterwiseNumberOfQuestionsByCourseObject($course)
    {
    	try {
    		/**
    		 * Make array to hold the number of questions chapter-wise and difficulty-wise.
    		 * Get the available diffibulty levels for further processing.
    		 */
    		$numberOfQuestions = array();
    		$difficultyLevels = (new DifficultyLevelRepository)->getPluckedListOfDifficultyLevelsByTitleAndId();

    		foreach ($course->chapters as $chapter) {
    			foreach ($difficultyLevels as $dlId => $difficultyLevel) {
    				if ($course->test && ($ctc = $course->test->chapters()->whereCourseChapterId($chapter->id)->whereDifficultyLevelId($dlId)->first()))
	    				$numberOfQuestions[$dlId][$chapter->id] = $ctc->number_of_questions;
	    			else
	    				$numberOfQuestions[$dlId][$chapter->id] = 0;
    			}
    		}

    		return $numberOfQuestions;
    	} catch (Exception $e) {
    		Log::channel('course')->error('[CourseService:getChapterwiseNumberOfQuestionsByCourseObject] Chapterwise number of questions not fetched by course object because an exception occurred: ');
    		Log::channel('course')->error($e->getMessage());

    		return false;
    	}
    }

    /**
     * Add test details by course object i.e. add number of questions chapter-wise and difficulty-wise.
     *
     * @param  array  $input
     * @param  \App\Models\Course  $course
     * @return boolean
     */
    public function addTestDetailsByCourseObject($input, $course)
    {
    	try {
    		/**
    		 * Check for the existenance of test related to the course.
    		 * IF test does not exists then create test before moving forward.
    		 */
    		if (!$course->test) {
    			/**
    			 * Input for course test creation.
    			 */
    			$courseTestInput['maximum_time'] = $input['maximum_time'];

    			/**
    			 * IF course test is not created successfully
    			 * THEN return false.
    			 * ELSE move forward with further processing.
    			 */
    			if (!$this->courseTestRepository->createCourseTestByCourseObject($courseTestInput, $course))
    				return false;
    		} else {
    			/**
				 * Update for the existing course test.
				 */
				$updateCourseTest['maximum_time'] = $input['maximum_time'];

				/**
    			 * IF course test is not updated successfully
    			 * THEN return false.
    			 * ELSE move forward with further processing.
    			 */
    			if (!$this->courseTestRepository->updateCourseTestByObject($updateCourseTest, $course->test))
    				return false;
    		}

    		/**
    		 * Update/Create the test chapters and associate them with the course test.
    		 * Get the available difficulty levels for further processing.
    		 */
    		$difficultyLevels = (new DifficultyLevelRepository)->getPluckedListOfDifficultyLevelsByTitleAndId();
    		foreach ($course->chapters as $index => $chapter) {
    			foreach ($difficultyLevels as $dlId => $difficultyLevel) {
    				/**
	    			 * IF test chapter is not created
	    			 * THEN create chapter test before moving.
	    			 */
    				if (!($ctc = $course->test->chapters()->whereCourseChapterId($chapter->id)->whereDifficultyLevelId($dlId)->first())) {
    					/**
    					 * Input for course test chapter creation.
    					 */
    					$courseTestChapterInput['course_chapter_id'] = $chapter->id;
    					$courseTestChapterInput['difficulty_level_id'] = $dlId;
    					$courseTestChapterInput['number_of_questions'] = $input['number_of_questions'][$dlId][$index];

	    				/**
		    			 * IF course test chapter is not created successfully
		    			 * THEN return false.
		    			 * ELSE move forward with further processing.
		    			 */
		    			if (!($ctc = $this->courseTestChapterRepository->createCourseTestChapterByCourseTestObject($courseTestChapterInput, $course->test)))
		    				return false;
    				} else {
    					/**
	    				 * Update for the existing test chapter.
	    				 */
    					$update['number_of_questions'] = $input['number_of_questions'][$dlId][$index];

    					/**
		    			 * IF course test chapter is not updated successfully
		    			 * THEN return false.
		    			 * ELSE move forward with further processing.
		    			 */
		    			if (!$this->courseTestChapterRepository->updateCourseTestChapterByObject($update, $ctc))
		    				return false;
    				}
    			}
    		}

    		/**
    		 * IF everything is passed successfully
    		 * that means updation/creation of test chapters is successful
    		 * SO return true.
    		 */
    		return true;
    	} catch (Exception $e) {
    		Log::channel('course')->error('[CourseService:addTestDetailsByCourseObject] Test details not added by course object because an exception occurred: ');
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
            /**
             * Save the topics in temporary variable for attaching with the course after creation.
             * And unset the 'topics' as that us not to be inserted in database.
             */
            $tempTopics = $update['topics'];
            unset($update['topics']);

            /**
             * If course is updated succesfully then do the further processing 
             * else return false. 
             */
            if($this->courseRepository->updateCourseByObject($update, $course)) {
                /**
                 * Associate topics with the course.
                 */
                $course->topics()->syncWithPivotValues(
                	$tempTopics,
                	[
                		'created_at' => now(),
                		'updated_at' => now()
                	]
                );

	            return true;
            }
            else
                return false;
		} catch (Exception $e) {
			Log::channel('course')->error('[CourseService:udateCourseByObject] Course not updated by object because an exception occurred: ');
			Log::channel('course')->error($e->getMessage());

			return false;
		}
	}

	/**
	 * Upload the courses from the excel.
	 *
	 * @param  \Illuminate\Http\UploadedFile  $uploadedFile
	 * @return array
	 */
	public function uploadCoursesExcel($uploadedFile)
	{
		try {
			Excel::import(new CoursesImport(), $uploadedFile);

			return [
				'result' => 1
			];
		} catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
			return [
				'result' => 2,
				'failures' => $e->failures()
			];
		} catch (Exception $e) {
			Log::channel('course')->error('[CourseService:uploadCoursesExcel] Courses excel not uploaded because an exception occurred: ');
			Log::channel('course')->error($e->getMessage());

			return [
				'result' => 0
			];
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
        	return $this->courseRepository->getFirstCourseBySlug($slug);
        } catch (Exception $e) {
			Log::channel('course')->error('[CourseService:getFirstCourseBySlug] First course not fetched by slug because an exception occurred: ');
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
        	return $this->courseRepository->getFirstCourseByName($name);
        } catch (Exception $e) {
			Log::channel('course')->error('[CourseService:getFirstCourseByName] First course not fetched by name because an exception occurred: ');
			Log::channel('course')->error($e->getMessage());

			return false;
		}
    }
}