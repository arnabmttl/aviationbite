<?php

namespace App\Services;

// Repositories
use App\Repositories\QuestionRepository;
use App\Repositories\QuestionOptionRepository;
use App\Repositories\PracticeTestRepository;
use App\Repositories\PracticeTestQuestionRepository;
use App\Repositories\PracticeTestChapterRepository;
use App\Repositories\CommentRepository;
use App\Repositories\UserTestRepository;
use App\Repositories\UserTestQuestionRepository;

// Support Facades
use Illuminate\Support\Facades\Log;
use \Illuminate\Database\Eloquent\Collection;

// Exception
use Exception;

class TestService extends BaseService
{
	/**
	 * PracticeTestRepository instance to use various functions of PracticeTestRepository.
	 *
	 * @var \App\Repositories\PracticeTestRepository
	 */
	protected $practiceTestRepository;

	/**
	 * PracticeTestQuestionRepository instance to use various functions of PracticeTestQuestionRepository.
	 *
	 * @var \App\Repositories\PracticeTestQuestionRepository
	 */
	protected $practiceTestQuestionRepository;

	/**
	 * PracticeTestChapterRepository instance to use various functions of PracticeTestChapterRepository.
	 *
	 * @var \App\Repositories\PracticeTestChapterRepository
	 */
	protected $practiceTestChapterRepository;

	/**
	 * UserTestRepository instance to use various functions of UserTestRepository.
	 *
	 * @var \App\Repositories\UserTestRepository
	 */
	protected $userTestRepository;

	/**
	 * UserTestQuestionRepository instance to use various functions of UserTestQuestionRepository.
	 *
	 * @var \App\Repositories\UserTestQuestionRepository
	 */
	protected $userTestQuestionRepository;

	/**
	 * Create a new service instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();
		$this->practiceTestRepository = new PracticeTestRepository;
		$this->practiceTestQuestionRepository = new PracticeTestQuestionRepository;
		$this->practiceTestChapterRepository = new PracticeTestChapterRepository;
		$this->userTestRepository = new UserTestRepository;
		$this->userTestQuestionRepository = new UserTestQuestionRepository;
	}

	/**
	 * Create a new practice test by course and user object.
	 *
	 * @param  array  $input
	 * @param  \App\Models\Course  $course
	 * @param  \App\Models\User  $user
	 * @return \App\Models\Course|boolean
	 */
	public function createPracticeTestByCourseAndUserObject($input, $course, $user)
	{
		try {
			/**
			 * QuestionRepository instance to use various functions of QuestionRepository.
			 */
			$questionRepository = new QuestionRepository;

			/**
			 * Difficulty Level and Question Type may or may not be present.
			 * As the same thing is required at a later stage as well so we
			 * will use these variables to store the values for using at later stage.
			 */
			$difficultyLevelId = null;
			$questionTypeId = null;

			/**
			 * Check the availability of difficulty level and question type
			 * in our input variable and correspondingly assign the values.
			 */
			if (isset($input['difficulty_level_id']) && isset($input['question_type_id'])) {
				$difficultyLevelId = $input['difficulty_level_id'];
				$questionTypeId = $input['question_type_id'];
			} else if (isset($input['difficulty_level_id']))
				$difficultyLevelId = $input['difficulty_level_id'];
			else if (isset($input['question_type_id']))
				$questionTypeId = $input['question_type_id'];

			/**
			 * Fetch the questions based on the number of questions,
			 * selected chapters, difficulty level and question type.
			 */
			$questions = $questionRepository->getQuestionsByChapterDifficultyAndType($input['number_of_questions'], $input['chapter_selected'], $difficultyLevelId, $questionTypeId);

			/**
			 * IF we are getting the questions
			 * THEN only we will go ahead with the practice test creation
			 * ELSE we will return false and log the issue.
			 */
			if ($questions) {
				/**
				 * Make input for practice test and create practice test based on the input.
	             * IF new practice test is created succesfully
	             * THEN do the further processing 
	             * ELSE return false.
	             */
				$practiceTestInput['course_id'] = $course->id;
	            if($newPracticeTest = $this->practiceTestRepository->createPracticeTestByUserObject($practiceTestInput, $user)) {
	            	/**
	            	 * Iterate over all the questions to associate them with the newly created
	            	 * practice test.
	            	 */
	            	foreach ($questions as $question) {
	            		/**
		                 * Make input for practice test questions and create the same.
		                 * IF new practice test question is not created successfully
		                 * THEN log the issue but do not stop further processing.
		                 */
	            		$ptqInput['question_id'] = $question->id;
	            		$ptqInput['status'] = 0;

		                if (!$this->practiceTestQuestionRepository->createPracticeTestQuestionByPracticeTestObject($ptqInput, $newPracticeTest))
		                	Log::channel('test')->error('[TestService:createPracticeTestByCourseAndUserObject] Question with id '.$question->id.' not attached with practice test with id '.$newPracticeTest->id.'.');
	            	}

	            	/**
					 * Group the questions chapter-wise then make input for
					 * practice_test_chapters table as we are not taking number
					 * of questions chapter-wise from the user. So, we will 
					 * assign the number of questions chapter-wise dynamically.
					 */
					$questionsGroupedByChapter = $questions->groupBy('course_chapter_id');
					foreach ($questionsGroupedByChapter as $key => $value) {
						/**
		                 * Make input for practice test chapters and create the same.
		                 * IF new practice test chapter is not created successfully
		                 * THEN log the issue but do not stop further processing.
		                 */
						$ptcInput['course_chapter_id'] = $key;
						$ptcInput['number_of_questions'] = $value->count();
						$ptcInput['difficulty_level_id'] = $difficultyLevelId;
						$ptcInput['question_type_id'] = $questionTypeId;

						if (!$this->practiceTestChapterRepository->createPracticeTestChapterByPracticeTestObject($ptcInput, $newPracticeTest))
		                	Log::channel('test')->error('[TestService:createPracticeTestByCourseAndUserObject] Chapter with id '.$key.' not attached with practice test with id '.$newPracticeTest->id.'.');
					}

					return $newPracticeTest;
	            }
	            else
	                return false;
			} else {
				Log::channel('test')->error('[TestService:createPracticeTestByCourseAndUserObject] Practice test not created by course and user object because questions not fetched.');

				return false;
			}
		} catch (Exception $e) {
			Log::channel('test')->error('[TestService:createPracticeTestByCourseAndUserObject] Practice test not created by course and user object because an exception occurred: ');
			Log::channel('test')->error($e->getMessage());

			return false;
		}
	}

	/**
     * Get the first practice test by the id and user id.
     *
     * @param  int  $id
     * @param  int  $userId
     * @return \App\Models\PracticeTest|boolean
     */
    public function getFirstPracticeTestByIdAndUserId($id, $userId)
    {
    	try {
    		return $this->practiceTestRepository->getFirstPracticeTestByIdAndUserId($id, $userId);
    	} catch (Exception $e) {
    		Log::channel('test')->error('[TestService:getFirstPracticeTestByIdAndUserId] First practice test not fetched by id and user id because an exception occurred: ');
    		Log::channel('test')->error($e->getMessage());

    		return false;
    	}
    }

    /**
     * Get the first practice test question by the id and user id.
     *
     * @param  int  $id
     * @param  int  $userId
     * @return \App\Models\PracticeTestQuestion|boolean
     */
    public function getFirstPracticeTestQuestionByIdAndUserId($id, $userId)
    {
    	try {
    		return $this->practiceTestQuestionRepository->getFirstPracticeTestQuestionByIdAndUserId($id, $userId);
    	} catch (Exception $e) {
    		Log::channel('test')->error('[TestService:getFirstPracticeTestQuestionByIdAndUserId] First practice test question not fetched by id and user id because an exception occurred: ');
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
    		/**
    		 * IF the practice test is already submitted
    		 * THEN do not make any update.
    		 */
    		if (!$practiceTestQuestion->practiceTest->is_submitted) {
    			/**
	    		 * IF a question is answered
	    		 * THEN check its correctness by fetching the option.
	    		 */
	    		if (isset($update['question_option_id']) && $questionOption = (new QuestionOptionRepository)->getFirstQuestionOptionById($update['question_option_id'])) {
	    			/**
	    			 * Add is_correct value for practice test question
	    			 * based on the value of option selected by the user.
	    			 */
	    			$update['is_correct'] = $questionOption->is_correct;
	    		}

	    		return $this->practiceTestQuestionRepository->updatePracticeTestQuestionByObject($update, $practiceTestQuestion);
    		} else {
    			Log::channel('test')->error('[TestService:updatePracticeTestQuestionByObject] Someone is trying to update an already submitted practice test.');
    			Log::channel('test')->error('PracticeTestQuestion : '.$practiceTestQuestion->id);

    			return true;
    		}
    	} catch (Exception $e) {
    		Log::channel('test')->error('[TestService:updatePracticeTestQuestionByObject] Practice test question not updated by object because an exception occurred: ');
    		Log::channel('test')->error($e->getMessage());

    		return false;
    	}
    }

    /**
     * Finish a practice test by object
     *
     * @param  \App\Models\PracticeTest  $practiceTest
     * @return boolean
     */
    public function finishPracticeTestByObject($practiceTest)
    {
    	try {
    		$update['is_submitted'] = 1;

    		return $this->practiceTestRepository->updatePracticeTestByObject($update, $practiceTest);
    	} catch (Exception $e) {
    		Log::channel('test')->error('[TestService:finishPracticeTestByObject] Practice test not finished by object because an exception occurred: ');
    		Log::channel('test')->error($e->getMessage());

    		return false;
    	}
    }

    /**
     * Create comment by practice test question object.
     *
     * @param  array<string, mixed>  $input
     * @param  \App\Models\PracticeTestQuestion  $practiceTestQuestion
     * @return \App\Models\Comment|boolean
     */
    public function createCommentByPracticeTestQuestionObject($input, $practiceTestQuestion)
    {
    	try {
    		/**
    		 * Add practice_test_question_id and change question_id for the input.
    		 */
    		$input['user_id'] = $practiceTestQuestion->practiceTest->user->id;
    		$input['practice_test_question_id'] = $practiceTestQuestion->id;
    		$input['question_id'] = $practiceTestQuestion->question->id;

    		return (new CommentRepository)->createComment($input);
    	} catch (Exception $e) {
    		Log::channel('test')->error('[TestService:createCommentByPracticeTestQuestionObject] Comment not created by practice test question object because an exception occurred: ');
    		Log::channel('test')->error($e->getMessage());

    		return false;
    	}
    }

    /**
	 * Create a new user test by course and user object.
	 *
	 * @param  \App\Models\Course  $course
	 * @param  \App\Models\User  $user
	 * @return \App\Models\UserTest|boolean
	 */
	public function createUserTestByCourseAndUserObject($course, $user)
	{
		try {
			/**
			 * QuestionRepository instance to use various functions of QuestionRepository.
			 */
			$questionRepository = new QuestionRepository;

			/**
			 * Fetch course's test. IF not created THEN log the issue return false.
			 * ELSE continue with user test creation.
			 */
			if (!($courseTest = $course->test)) {
				Log::channel('test')->error('[TestService:createUserTestByCourseAndUserObject] User test not created by course and user object because the test of the course is not yet created.');

				return false;
			}

			/**
			 * Fetch the questions based on the course test details.
			 */
			$questions = new Collection();
			foreach ($courseTest->chapters as $chapter) {
				if ($tempQuestions = $questionRepository->getQuestionsByChapterDifficultyAndType($chapter->number_of_questions, [$chapter->course_chapter_id], $chapter->difficulty_level_id))
					$questions = $questions->merge($tempQuestions);
				else {
					Log::channel('test')->error('[TestService:createUserTestByCourseAndUserObject] User test not created by course and user object because the questions are not fetched properly.');

					return false;
				}
			}

			/**
			 * IF we are getting the questions
			 * THEN only we will go ahead with the user test creation
			 * ELSE we will return false and log the issue.
			 */
			if ($questions) {
				/**
				 * Make input for user test and create user test based on the input.
	             * IF new user test is created succesfully
	             * THEN do the further processing 
	             * ELSE return false.
	             */
				$userTestInput['course_id'] = $course->id;
	            if($newUserTest = $this->userTestRepository->createUserTestByUserObject($userTestInput, $user)) {
	            	/**
	            	 * Iterate over all the questions to associate them with the newly created
	            	 * user test.
	            	 */
	            	foreach ($questions as $question) {
	            		/**
		                 * Make input for user test questions and create the same.
		                 * IF new user test question is not created successfully
		                 * THEN log the issue but do not stop further processing.
		                 */
	            		$utqInput['question_id'] = $question->id;
	            		$utqInput['status'] = 0;

		                if (!$this->userTestQuestionRepository->createUserTestQuestionByUserTestObject($utqInput, $newUserTest))
		                	Log::channel('test')->error('[TestService:createUserTestByCourseAndUserObject] Question with id '.$question->id.' not attached with user test with id '.$newUserTest->id.'.');
	            	}

					return $newUserTest;
	            }
	            else
	                return false;
			} else {
				Log::channel('test')->error('[TestService:createUserTestByCourseAndUserObject] User test not created by course and user object because questions not fetched.');

				return false;
			}
		} catch (Exception $e) {
			Log::channel('test')->error('[TestService:createUserTestByCourseAndUserObject] User test not created by course and user object because an exception occurred: ');
			Log::channel('test')->error($e->getMessage());

			return false;
		}
	}

	/**
     * Finish a user test by object
     *
     * @param  \App\Models\UserTest  $userTest
     * @return boolean
     */
    public function finishUserTestByObject($userTest)
    {
    	try {
    		$update['is_submitted'] = 1;

    		return $this->userTestRepository->updateUserTestByObject($update, $userTest);
    	} catch (Exception $e) {
    		Log::channel('test')->error('[TestService:finishUserTestByObject] User test not finished by object because an exception occurred: ');
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
    		/**
    		 * IF the user test is already submitted
    		 * THEN do not make any update.
    		 */
    		if (!$userTestQuestion->userTest->is_submitted) {
    			/**
	    		 * IF a question is answered
	    		 * THEN check its correctness by fetching the option.
	    		 */
	    		if (isset($update['question_option_id']) && $questionOption = (new QuestionOptionRepository)->getFirstQuestionOptionById($update['question_option_id'])) {
	    			/**
	    			 * Add is_correct value for user test question
	    			 * based on the value of option selected by the user.
	    			 */
	    			$update['is_correct'] = $questionOption->is_correct;
	    		}

	    		$update['time_taken'] = gmdate("H:i:s", $update['time_taken']);

	    		return $this->userTestQuestionRepository->updateUserTestQuestionByObject($update, $userTestQuestion);
    		} else {
    			Log::channel('test')->error('[TestService:updateUserTestQuestionByObject] Someone is trying to update an already submitted user test.');
    			Log::channel('test')->error('UserTestQuestion : '.$userTestQuestion->id);

    			return true;
    		}
    	} catch (Exception $e) {
    		Log::channel('test')->error('[TestService:updateUserTestQuestionByObject] User test question not updated by object because an exception occurred: ');
    		Log::channel('test')->error($e->getMessage());

    		return false;
    	}
    }
}