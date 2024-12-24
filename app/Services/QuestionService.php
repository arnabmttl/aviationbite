<?php

namespace App\Services;

// Models
use App\Models\Document;

// Repositories
use App\Repositories\QuestionRepository;
use App\Repositories\DocumentRepository;
use App\Repositories\QuestionOptionRepository;

// Imports
use App\Imports\QuestionsImport;

// Laravel Excel
use Maatwebsite\Excel\Facades\Excel;

// Support Facades
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

// Exception
use Exception;

class QuestionService extends BaseService
{
	/**
	 * QuestionRepository instance to use various functions of QuestionRepository.
	 *
	 * @var \App\Repositories\QuestionRepository
	 */
	protected $questionRepository;

	/**
	 * DocumentRepository instance to use various functions of DocumentRepository.
	 *
	 * @var \App\Repositories\DocumentRepository
	 */
	protected $documentRepository;

	/**
	 * QuestionOptionRepository instance to use various functions of QuestionOptionRepository.
	 *
	 * @var \App\Repositories\QuestionOptionRepository
	 */
	protected $questionOptionRepository;

	/**
	 * Create a new service instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();
		$this->questionRepository = new QuestionRepository;
		$this->documentRepository = new DocumentRepository;
		$this->questionOptionRepository = new QuestionOptionRepository;
	}

	/**
	 * Get the paginated list of questions.
	 *
	 * @param  int  $perPage
	 * @return \Illuminate\Pagination\LengthAwarePaginator|boolean
	 */
	public function getPaginatedListOfQuestions($perPage)
	{
		return $this->questionRepository->getPaginatedListOfQuestions($perPage);
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
			/**
			 * Segregate question related input and create question.
			 * IF question is created successfully
			 * THEN create the options
			 * ELSE return false.
			 */
			$questionInput['question_id'] = $input['question_id'];
			$questionInput['course_chapter_id'] = $input['course_chapter_id'];
			$questionInput['difficulty_level_id'] = $input['difficulty_level_id'];
			$questionInput['question_type_id'] = $input['question_type_id'];
			$questionInput['previous_years'] = $input['previous_years'];
			$questionInput['title'] = $input['title'];
			$questionInput['description'] = $input['description'];
			$questionInput['explanation'] = $input['explanation'];
			$questionInput['practice_test_comment'] = $input['practice_test_comment'];

            if ($newQuestion = $this->questionRepository->createQuestion($questionInput)) {
            	/**
            	 * Check if the question image is coming or not.
            	 * IF question image is coming
            	 * THEN save the same in storage and link it with the question
            	 */
            	if (isset($input['question_image'])) {
            		/**
	                 * Save question image to storage.
	                 */
	                $questionImage = Storage::put('/public/questions/'.$newQuestion->id, $input['question_image']);

            		/**
	                 * Create new document by the documentable object.
	                 */
            		$documentInput['document_type'] = 1;
            		$documentInput['type'] = 'Question Image';
            		$documentInput['url'] = 'questions/'.$newQuestion->id.'/'.basename($questionImage);

            		/**
	                 * IF image file is not associated with the question
	                 * THEN remove the image from storage, delete the question, log the issue and return false.
	                 */
	                if (!$this->documentRepository->createDocumentByDocumentableObject($documentInput, $newQuestion)) {
	                    /**
	                     * Check if image is saved in storage or not. If so, then delete it.
	                     */
	                    if(Storage::exists('/public/questions/'.$newQuestion->id.'/'.basename($questionImage)))
	                        Storage::delete('/public/questions/'.$newQuestion->id.'/'.basename($questionImage));

	                    /**
	                     * Delete the newly created question as image is not associated with the question.
	                     */
	                    $newQuestion->delete();

	                    /**
	                     * Log the issue for debugging.
	                     */
	                    Log::channel('question')->error('[QuestionService:createQuestion] Question not added because some issue occurred in relating the question with image(s).');

	                    return false;
	                }
            	}

            	/**
            	 * Iterate over all the options, create option and associate it with the question.
            	 */
            	foreach ($input['option_title'] as $key => $value) {
            		/**
					 * Segregate option related input and create option.
					 * IF option is created successfully
					 * THEN move to next option
					 * ELSE delete the newly created question and return false.
					 */
					$optionInput['title'] = $value;
					$optionInput['is_correct'] = $input['is_correct'][$key];

		            if ($newQuestionOption = $this->questionOptionRepository->createQuestionOptionByQuestionObject($optionInput, $newQuestion)) {
		            	/**
		            	 * Check if the option image is coming or not.
		            	 * IF option image is coming
		            	 * THEN save the same in storage and link it with the option
		            	 */
		            	if (isset($input['image'][$key])) {
		            		/**
			                 * Save option image to storage.
			                 */
			                $optionImage = Storage::put('/public/questions/'.$newQuestion->id, $input['image'][$key]);

		            		/**
			                 * Create new document by the documentable object.
			                 */
		            		$documentInput['document_type'] = 1;
		            		$documentInput['type'] = 'Option Image';
		            		$documentInput['url'] = 'questions/'.$newQuestion->id.'/'.basename($optionImage);

		            		/**
			                 * IF image file is not associated with the option
			                 * THEN remove the image from storage, delete the option, log issue and return false.
			                 */
			                if (!$this->documentRepository->createDocumentByDocumentableObject($documentInput, $newQuestionOption)) {
			                    /**
			                     * Check if image is saved in storage or not. If so, then delete it.
			                     */
			                    if(Storage::exists('/public/questions/'.$newQuestion->id.'/'.basename($optionImage)))
			                        Storage::delete('/public/questions/'.$newQuestion->id.'/'.basename($optionImage));

			                    /**
			                     * Delete the newly created question as image is not associated with the option.
			                     */
			                    $newQuestion->delete();

			                    /**
			                     * Log the issue for debugging.
			                     */
			                    Log::channel('question')->error('[QuestionService:createQuestion] Question not added because some issue occurred in relating the option with image(s).');

			                    return false;
			                }
		            	}
		            } else {
		            	/**
	                     * Delete the newly created question as option is not associated with the question.
	                     */
	                    $newQuestion->delete();

	                    /**
	                     * Log the issue for debugging.
	                     */
	                    Log::channel('question')->error('[QuestionService:createQuestion] Question not added because some issue occurred in relating the option with question.');

	                    return false;
		            }
            	}

            	return $newQuestion;
            }
            else
                return false;
		} catch (Exception $e) {
			Log::channel('question')->error('[QuestionService:createQuestion] Question not created because an exception occurred: ');
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
			return $this->questionRepository->getTotalQuestionsByChaptersDifficultyAndType($selectedChapters, $difficultyLevelId, $questionTypeId);
		} catch (Exception $e) {
			Log::channel('test')->error('[QuestionService:getTotalQuestionsByChaptersDifficultyAndType] Total questions by chapters, difficulty and type not fetched because an exception occurred: ');
			Log::channel('test')->error($e->getMessage());

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
			return $this->questionRepository->getPaginatedListOfQuestionsBySearchTerms($questionId, $courseId, $chapterId, $difficultyLevelId, $questionTypeId, $perPage);
		} catch (Exception $e) {
			Log::channel('question')->error('[QuestionService:getPaginatedListOfQuestionsBySearchTerms] Paginated list of questions not fetched by search terms because an exception occurred: ');
			Log::channel('question')->error($e->getMessage());

			return false;
		}
	}

	/**
	 * Upload the questions from the excel.
	 *
	 * @param  \Illuminate\Http\UploadedFile  $uploadedFile
	 * @return array
	 */
	public function uploadQuestionsExcel($uploadedFile)
	{
		try {
			Excel::import(new QuestionsImport(), $uploadedFile);

			return [
				'result' => 1
			];
		} catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
			return [
				'result' => 2,
				'failures' => $e->failures()
			];
		} catch (Exception $e) {
			Log::channel('question')->error('[QuestionService:uploadQuestionsExcel] Questions excel not uploaded because an exception occurred: ');
			Log::channel('question')->error($e->getMessage());

			return [
				'result' => 0
			];
		}
	}

	/**
	 * Update a question by object
	 *
	 * @param  array  $input
	 * @param  \App\Models\Question  $question
	 * @return boolean
	 */
	public function updateQuestionByObject($input, $question)
	{
		try {
			/**
			 * Segregate question related update and update question.
			 * IF question is updated successfully
			 * THEN update the options
			 * ELSE return false.
			 */
			$questionUpdate['question_id'] = $input['question_id'];
			$questionUpdate['difficulty_level_id'] = $input['difficulty_level_id'];
			$questionUpdate['question_type_id'] = $input['question_type_id'];
			$questionUpdate['previous_years'] = $input['previous_years'];
			$questionUpdate['title'] = $input['title'];
			$questionUpdate['description'] = $input['description'];
			$questionUpdate['explanation'] = $input['explanation'];
			$questionUpdate['practice_test_comment'] = $input['practice_test_comment'];

            if ($result = $this->questionRepository->updateQuestionByObject($questionUpdate, $question)) {
            	/**
            	 * Check if the question image is coming or not.
            	 * IF question image is coming
            	 * THEN save the same in storage and link it with the question
            	 */
            	if (isset($input['question_image'])) {
            		/**
            		 * IF there is already an image associated with the question
            		 * THEN delete it.
            		 */
            		if ($question->question_image) {
            			$question->question_image->delete();
            		}

            		/**
	                 * Save question image to storage.
	                 */
	                $questionImage = Storage::put('/public/questions/'.$question->id, $input['question_image']);

            		/**
	                 * Create new document by the documentable object.
	                 */
            		$documentInput['document_type'] = 1;
            		$documentInput['type'] = 'Question Image';
            		$documentInput['url'] = 'questions/'.$question->id.'/'.basename($questionImage);

            		/**
	                 * IF image file is not associated with the question
	                 * THEN remove the image from storage, delete the question, log the issue and return false.
	                 */
	                if (!$this->documentRepository->createDocumentByDocumentableObject($documentInput, $question)) {
	                    /**
	                     * Check if image is saved in storage or not. If so, then delete it.
	                     */
	                    if(Storage::exists('/public/questions/'.$question->id.'/'.basename($questionImage)))
	                        Storage::delete('/public/questions/'.$question->id.'/'.basename($questionImage));

	                    /**
	                     * Log the issue for debugging.
	                     */
	                    Log::channel('question')->error('[QuestionService:updateQuestionByObject] Question image not updated because some issue occurred in relating the question with image(s).');

	                    return false;
	                }
            	}

            	/**
            	 * Iterate over all the options, create option and associate it with the question.
            	 */
            	foreach ($question->options as $key => $option) {
            		/**
					 * Segregate option related input and create option.
					 * IF option is created successfully
					 * THEN move to next option
					 * ELSE delete the newly created question and return false.
					 */
					$optionUpdate['title'] = $input['option_title'][$key];
					$optionUpdate['is_correct'] = $input['is_correct'][$key];

		            if ($this->questionOptionRepository->updateQuestionOptionByObject($optionUpdate, $option)) {
		            	/**
		            	 * Check if the option image is coming or not.
		            	 * IF option image is coming
		            	 * THEN save the same in storage and link it with the option
		            	 */
		            	if (isset($input['image'][$key])) {
		            		/**
		            		 * IF there is already an image associated with the option
		            		 * THEN delete it.
		            		 */
		            		if ($option->option_image) {
		            			$option->option_image->delete();
		            		}

		            		/**
			                 * Save option image to storage.
			                 */
			                $optionImage = Storage::put('/public/questions/'.$question->id, $input['image'][$key]);

		            		/**
			                 * Create new document by the documentable object.
			                 */
		            		$documentInput['document_type'] = 1;
		            		$documentInput['type'] = 'Option Image';
		            		$documentInput['url'] = 'questions/'.$question->id.'/'.basename($optionImage);

		            		/**
			                 * IF image file is not associated with the option
			                 * THEN remove the image from storage, delete the option, log issue and return false.
			                 */
			                if (!$this->documentRepository->createDocumentByDocumentableObject($documentInput, $option)) {
			                    /**
			                     * Check if image is saved in storage or not. If so, then delete it.
			                     */
			                    if(Storage::exists('/public/questions/'.$question->id.'/'.basename($optionImage)))
			                        Storage::delete('/public/questions/'.$question->id.'/'.basename($optionImage));

			                    /**
			                     * Log the issue for debugging.
			                     */
			                    Log::channel('question')->error('[QuestionService:updateQuestionByObject] Question not updated because some issue occurred in relating the option with image(s).');

			                    return false;
			                }
		            	}
		            } else {
	                    /**
	                     * Log the issue for debugging.
	                     */
	                    Log::channel('question')->error('[QuestionService:updateQuestionByObject] Question not updated because some issue occurred in updating the option.');

	                    return false;
		            }
            	}

            	return $result;
            }
            else
                return false;
		} catch (Exception $e) {
			Log::channel('question')->error('[QuestionService:updateQuestionByObject] Question not updated because an exception occurred: ');
			Log::channel('question')->error($e->getMessage());

			return false;
		}
	}
}