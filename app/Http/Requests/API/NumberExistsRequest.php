<?php

namespace App\Http\Requests\API;

use Illuminate\Foundation\Http\FormRequest;

class NumberExistsRequest extends FormRequest
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
            'phone_number' => 'required|min:10|max:10|regex:/^[0-9]+$/',
        ];
    }
}
