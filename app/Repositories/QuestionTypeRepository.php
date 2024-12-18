<?php

namespace App\Repositories;

// Model for this repository
use App\Models\QuestionType;

// Support Facades
use Illuminate\Support\Facades\Log;

// Exception
use Exception;

class QuestionTypeRepository extends BaseRepository
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
	 * Get the total number of question types available.
	 *
	 * @return int|boolean
	 */
	public function getTotalQuestionTypes()
	{
		try {
			return QuestionType::count();
		} catch (Exception $e) {
			Log::channel('question')->error('[QuestionTypeRepository:getTotalQuestionTypes] Total question types not fetched because an exception occurred: ');
			Log::channel('question')->error($e->getMessage());

			return false;
		}
	}

	/**
	 * Create a new question type.
	 *
	 * @param  array  $questionTypeDetails
	 * @return \App\Models\QuestionType|boolean
	 */
	public function createQuestionType($questionTypeDetails)
	{
		try {
			return QuestionType::create($questionTypeDetails);
		} catch (Exception $e) {
			Log::channel('question')->error('[QuestionTypeRepository:createQuestionType] New question type not created because an exception occurred: ');
			Log::channel('question')->error($e->getMessage());

			return false;
		}
	}

	/**
	 * Get the plucked list of question types by title and id.
	 *
	 * @return \Illuminate\Support\Collection|boolean
	 */
	public function getPluckedListOfQuestionTypesByTitleAndId()
	{
		try {
			return QuestionType::pluck('title', 'id');
		} catch (Exception $e) {
			Log::channel('question')->error('[QuestionTypeRepository:getPluckedListOfQuestionTypesByTitleAndId] Plucked list of question types by title and id not fetched because an exception occurred: ');
			Log::channel('question')->error($e->getMessage());

			return false;
		}
	}

	/**
     * Get the first question type by the title.
     *
     * @param  string  $title
     * @return \App\Models\QuestionType|boolean
     */
    public function getFirstQuestionTypeByTitle($title)
    {
        try {
            return QuestionType::whereTitle($title)->first();
        } catch (Exception $e) {
            Log::channel('question')->error('[QuestionTypeRepository:getFirstQuestionTypeByTitle] First question type by title not fetched because an exception occured: ');
            Log::channel('question')->error($e->getMessage());

            return false;
        }
    }
}