<?php

namespace App\Http\Requests\Backend;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'dob' => 'nullable|date',
            'gender' => 'nullable|in:Male,Female',
            'designation' => 'nullable|in:Future Pilot,Trainee pilot,Airline Pilot,Aviation enthusiastic',
            'address' => 'nullable|string',
            'picture' => 'nullable|image',
            'goal' => 'nullable|string',
            'newsletter' => 'nullable'
        ];
    }
}
