<?php

namespace App\Repositories;

// Model for the repository
use App\Models\Question;

// Support Facades
use Illuminate\Support\Facades\Log;

// Database Eloquent Builder
use Illuminate\Database\Eloquent\Builder;

// Exception
use Exception;

class QuestionRepository extends BaseRepository
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
	 * Get the paginated list of questions.
	 *
	 * @param  int  $perPage
	 * @return \Illuminate\Pagination\LengthAwarePaginator|boolean
	 */
	public function getPaginatedListOfQuestions($perPage)
	{
		try {
			return Question::paginate($perPage);
		} catch (Exception $e) {
			Log::channel('question')->error('[QuestionRepository:getPaginatedListOfQuestions] Paginated list of questions at not fetched because an exception occurred: ');
			Log::channel('question')->error($e->getMessage());

			return false;
		}
	}

	/**
	 * Create a new question.
	 *
	 * @param  array  $input
	 * @return \App\Models\Question|boolean
	 */
	public function createQuestion($input)
	{
		try {
			return Question::create($input);
		} catch (Exception $e) {
			Log::channel('question')->error('[QuestionRepository:createQuestion] New question not created because an exception occurred: ');
			Log::channel('question')->error($e->getMessage());

			return false;
		}
	}

	/**
	 * Get the given number of questions based on the selected chapters,
	 * difficulty level and question type. Out of these number of questions
	 * and selected chapters are mandatory while difficulty level and 
	 * question type may or may not be present.
	 *
	 * @param  int  $numberOfQuestions
	 * @param  array  $selectedChapters
	 * @param  int|null  $difficultyLevelId
	 * @param  int|null  $questionTypeId
	 * @return \Illuminate\Database\Eloquent\Collection|boolean
	 */
	public function getQuestionsByChapterDifficultyAndType($numberOfQuestions, $selectedChapters, $difficultyLevelId=null, $questionTypeId=null)
	{
		try {
			/**
			 * Selected chapters are mandatory for getting the questions so no check required.
			 * We will make the query where the course_chapter_id has any of the given values.
			 */
			$query = Question::whereIn('course_chapter_id', $selectedChapters);

			/**
			 * Difficulty level may or not be present. So, we will check for it.
			 * IF difficulty level id is coming then we will put a where clause for that
			 * ELSE we will not consider the difficulty level at all in fetching the questions.
			 */
			if (isset($difficultyLevelId)) 
				$query->whereDifficultyLevelId($difficultyLevelId);

			/**
			 * Question type may or not be present. So, we will check for it.
			 * IF question type id is coming then we will put a where clause for that
			 * ELSE we will not consider the question type at all in fetching the questions.
			 */
			if (isset($questionTypeId)) 
				$query->whereQuestionTypeId($questionTypeId);

			/**
			 * Fetch the questions in a random order.
			 */
			$query->inRandomOrder();

			/**
			 * Fetch the given number of questions.
			 */
			$query->limit($numberOfQuestions);

			return $query->get();
		} catch (Exception $e) {
			Log::channel('question')->error('[QuestionRepository:getQuestionsByChapterDifficultyAndType] Questions not fetched by chapter, difficulty and type because an exception occurred: ');
			Log::channel('question')->error($e->getMessage());

			return false;
		}
	}

	/**
	 * Get the total number of questions based on the selected chapters,
	 * difficulty level and question type. Out of these selected chapters 
	 * is mandatory while difficulty level and question type may or may not be present.
	 *
	 * @param  array  $selectedChapters
	 * @param  int|null  $difficultyLevelId
	 * @param  int|null  $questionTypeId
	 * @return \Illuminate\Database\Eloquent\Collection|boolean
	 */
	public function getTotalQuestionsByChaptersDifficultyAndType($selectedChapters, $difficultyLevelId=null, $questionTypeId=null)
	{
		try {
			/**
			 * Selected chapters are mandatory for getting the questions so no check required.
			 * We will make the query where the course_chapter_id has any of the given values.
			 */
			$query = Question::whereIn('course_chapter_id', $selectedChapters);

			/**
			 * Difficulty level may or not be present. So, we will check for it.
			 * IF difficulty level id is coming then we will put a where clause for that
			 * ELSE we will not consider the difficulty level at all in fetching the questions.
			 */
			if (isset($difficultyLevelId)) 
				$query->whereDifficultyLevelId($difficultyLevelId);

			/**
			 * Question type may or not be present. So, we will check for it.
			 * IF question type id is coming then we will put a where clause for that
			 * ELSE we will not consider the question type at all in fetching the questions.
			 */
			if (isset($questionTypeId)) 
				$query->whereQuestionTypeId($questionTypeId);

			return $query->count();
		} catch (Exception $e) {
			Log::channel('question')->error('[QuestionRepository:getTotalQuestionsByChaptersDifficultyAndType] Total number of questions not fetched by chapters, difficulty and type because an exception occurred: ');
			Log::channel('question')->error($e->getMessage());

			return false;
		}
	}

	/**
	 * Get the paginated list of questions based on the question id, course,
	 * chapter, difficulty level and question type. Out of these nothing is mandatory.
	 *
	 * @param  int|null  $questionId
	 * @param  int|null  $courseId
	 * @param  int|null  $chapterId
	 * @param  int|null  $difficultyLevelId
	 * @param  int|null  $questionTypeId
	 * @param  int  $perPage
	 * @return \Illuminate\Database\Eloquent\Collection|boolean
	 */
	public function getPaginatedListOfQuestionsBySearchTerms($questionId, $courseId, $chapterId, $difficultyLevelId, $questionTypeId, $perPage)
	{
		try {
			/**
			 * We will make a default query to select all the columns from the table.
			 */
			$query = Question::select('*');

			/**
			 * Question id may or not be present. So, we will check for it.
			 * IF question id is coming then we will put a where clause for that
			 * ELSE we will not consider the question id at all in fetching the questions.
			 */
			if (isset($questionId)) 
				$query->where('question_id', 'like', '%'.$questionId.'%');

			/**
			 * Course may or not be present. So, we will check for it.
			 * IF course id is coming then we will put a where clause for that
			 * ELSE we will not consider the course at all in fetching the questions.
			 */
			if (isset($courseId)) 
				$query->whereHas('chapter', function (Builder $query1) use ($courseId) {
					$query1->whereCourseId($courseId);
				});

			/**
			 * Chapter may or not be present. So, we will check for it.
			 * IF chapter id is coming then we will put a where clause for that
			 * ELSE we will not consider the chapter at all in fetching the questions.
			 */
			if (isset($chapterId)) 
				$query->whereCourseChapterId($chapterId);

			/**
			 * Difficulty level may or not be present. So, we will check for it.
			 * IF difficulty level id is coming then we will put a where clause for that
			 * ELSE we will not consider the difficulty level at all in fetching the questions.
			 */
			if (isset($difficultyLevelId)) 
				$query->whereDifficultyLevelId($difficultyLevelId);

			/**
			 * Question type may or not be present. So, we will check for it.
			 * IF question type id is coming then we will put a where clause for that
			 * ELSE we will not consider the question type at all in fetching the questions.
			 */
			if (isset($questionTypeId)) 
				$query->whereQuestionTypeId($questionTypeId);

			return $query->paginate($perPage);
		} catch (Exception $e) {
			Log::channel('question')->error('[QuestionRepository:getPaginatedListOfQuestionsBySearchTerms] Paginated list of questions not fetched by search terms because an exception occurred: ');
			Log::channel('question')->error($e->getMessage());

			return false;
		}
	}

	/**
     * Update question by object.
     *
     * @param  array  $update
     * @param  \App\Models\Question  $question
     * @return boolean
     */
    public function updateQuestionByObject($update, $question)
    {
        try {
            return $question->update($update);
        } catch (Exception $e) {
            Log::channel('question')->error('[QuestionRepository:updateQuestionByObject] Question not updated by object because an exception occured: ');
            Log::channel('question')->error($e->getMessage());

            return false;
        }
    }
}