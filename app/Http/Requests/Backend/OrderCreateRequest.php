<?php

namespace App\Http\Requests\Backend;

use Illuminate\Foundation\Http\FormRequest;

// Services
use App\Services\CryptoService;

// Support Facades
use Illuminate\Support\Facades\Log;

// Exception
use Exception;

class OrderCreateRequest extends FormRequest
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
        return [
            'discount_code' => 'nullable|exists:discounts,code',
            'course_id' => 'required|array|exists:courses,id',
            'course_id.*' => 'required|distinct'
        ];
    }

    /**
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function getValidatorInstance()
    {
        /**
         * Decrypt the encrypted course ids before validating them.
         */
        try{
            $temp = array();
            foreach ($this->course_id as $key => $value) {
                if($courseId = (new CryptoService)->decryptValue($value)) {
                    $temp[] = $courseId;
                } else {
                    $this->course_id = null;
                    Log::channel('order')->error('[OrderCreateRequest:getValidatorInstance] Create Order Request validation failed because an exception occured. Visit normal log file to check the exception.');
                    break;
                }
            }
        } catch (Exception $e) {
            $this->course_id = null;

            Log::channel('order')->error('[OrderCreateRequest:getValidatorInstance] Create Order Request validation failed because an exception occured: ');
            Log::channel('order')->error($e->getMessage());
        }

        $this->request->set('course_id', $temp);

        return parent::getValidatorInstance();
    }
}
