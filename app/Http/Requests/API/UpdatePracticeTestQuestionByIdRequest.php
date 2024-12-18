<?php

namespace App\Http\Requests\API;

use Illuminate\Foundation\Http\FormRequest;

// Services
use App\Services\CryptoService;

// Support Facades
use Illuminate\Support\Facades\Log;

// Exception
use Exception;

class UpdatePracticeTestQuestionByIdRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        /**
         * These validations are not working. So need to figure out a way to make these validations work.
         */
        return [
            // 'question_id' => 'required|exists:practice_test_questions,id',
            // 'user_id' => 'required|exists:users,id',
            'status' => 'required|in:0,1,2,3,4',
            'question_option_id' => 'nullable|exists:question_options,id',
            'time_taken' => 'nullable'
        ];
    }

    /**
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function getValidatorInstance()
    {
        /**
         * Decrypt the encrypted question id and user id before validating them.
         */
        try{
            $cryptoService = new CryptoService;

            /**
             * IF decryption is successful
             * THEN assign the decrypted values to the input fields
             * ELSE make the input fields null and log the issue.
             */
            if (($questionId = $cryptoService->decryptValue($this->question_id)) && ($userId = $cryptoService->decryptValue($this->user_id))) {
                $this->question_id = $questionId;
                $this->user_id = $userId;
            } else {
                $this->question_id = null;
                $this->user_id = null;

                Log::channel('test')->error('[UpdatePracticeTestQuestionByIdRequest:getValidatorInstance] Update practice test question by id request validation failed because an exception occured. Visit normal log file to check the exception.');
            }
        } catch (Exception $e) {
            $this->question_id = null;
            $this->user_id = null;

            Log::channel('test')->error('[UpdatePracticeTestQuestionByIdRequest:getValidatorInstance] Update practice test question by id request validation failed because an exception occured: ');
            Log::channel('test')->error($e->getMessage());
        }

        return parent::getValidatorInstance();
    }
}
