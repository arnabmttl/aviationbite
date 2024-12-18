<?php

namespace App\Http\Requests\API;

use Illuminate\Foundation\Http\FormRequest;

// Services
use App\Services\CryptoService;

// Support Facades
use Illuminate\Support\Facades\Log;

// Exception
use Exception;

class GetQuestionsByUserTestIdRequest extends FormRequest
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
            // 'user_test_id' => 'required|exists:user_tests,id,user_id,'.$this->user_id,
            // 'user_id' => 'required|exists:users,id'
        ];
    }

    /**
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function getValidatorInstance()
    {
        /**
         * Decrypt the encrypted user test id and user id before validating them.
         */
        try{
            $cryptoService = new CryptoService;

            /**
             * IF decryption is successful
             * THEN assign the decrypted values to the input fields
             * ELSE make the input fields null and log the issue.
             */
            if (($userTestId = $cryptoService->decryptValue($this->user_test_id)) && ($userId = $cryptoService->decryptValue($this->user_id))) {
                $this->user_test_id = $userTestId;
                $this->user_id = $userId;
            } else {
                $this->user_test_id = null;
                $this->user_id = null;

                Log::channel('test')->error('[GetQuestionsByUserTestIdRequest:getValidatorInstance] Get questions by user test id request validation failed because an exception occured. Visit normal log file to check the exception.');
            }
        } catch (Exception $e) {
            $this->user_test_id = null;
            $this->user_id = null;

            Log::channel('test')->error('[GetQuestionsByUserTestIdRequest:getValidatorInstance] Get questions by user test id request validation failed because an exception occured: ');
            Log::channel('test')->error($e->getMessage());
        }

        return parent::getValidatorInstance();
    }
}
