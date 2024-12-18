<?php

namespace App\Repositories;

// Model for the repository
use App\Models\QuestionOption;

// Support Facades
use Illuminate\Support\Facades\Log;

// Exception
use Exception;

class QuestionOptionRepository extends BaseRepository
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
	 * Create a new option by question object.
	 *
	 * @param  array  $input
	 * @param  \App\Models\Question  $question
	 * @return \App\Models\QuestionOption|boolean
	 */
	public function createQuestionOptionByQuestionObject($input, $question)
	{
		try {
			$newQuestionOption = new QuestionOption($input);

			return $question->options()->save($newQuestionOption);
		} catch (Exception $e) {
			Log::channel('question')->error('[QuestionOptionRepository:createQuestionOptionByQuestionObject] New question option not created by question object because an exception occurred: ');
			Log::channel('question')->error($e->getMessage());

			return false;
		}
	}

	/**
	 * Get the first question option by id.
	 *
	 * @param  int  $id
	 * @return \App\Models\QuestionOption|boolean
	 */
	public function getFirstQuestionOptionById($id)
	{
		try {
			return QuestionOption::whereId($id)->first();
		} catch (Exception $e) {
			Log::channel('question')->error('[QuestionOptionRepository:getFirstQuestionOptionById] First question option not fetched by id because an exception occurred: ');
			Log::channel('question')->error($e->getMessage());

			return false;
		}
	}

	/**
     * Update question option by object.
     *
     * @param  array  $update
     * @param  \App\Models\QuestionOption  $questionOption
     * @return boolean
     */
    public function updateQuestionOptionByObject($update, $questionOption)
    {
        try {
            return $questionOption->update($update);
        } catch (Exception $e) {
            Log::channel('question')->error('[QuestionOptionRepository:updateQuestionOptionByObject] Question option not updated by object because an exception occured: ');
            Log::channel('question')->error($e->getMessage());

            return false;
        }
    }
}