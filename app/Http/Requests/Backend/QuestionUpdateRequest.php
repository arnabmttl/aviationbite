<?php

namespace App\Http\Requests\Backend;

use Illuminate\Foundation\Http\FormRequest;

class QuestionUpdateRequest extends FormRequest
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
            'question_id' => 'required|string|max:255|unique:questions,question_id,'.$this->segment(3),
            'difficulty_level_id' => 'required|exists:difficulty_levels,id',
            'question_type_id' => 'required|exists:question_types,id',
            'previous_years' => 'nullable|string|max:255',
            'title' => 'required|string',
            'question_image' => 'nullable|image',
            'description' => 'nullable|string',
            'explanation' => 'nullable|string',
            'option_title' => 'required|array',
            'option_title.*' => 'required|string',
            'image' => 'nullable|array',
            'image.*' => 'nullable|image',
            'is_correct' => 'required|array',
            'is_correct.*' => 'required|in:0,1',
            'practice_test_comment' => 'nullable'
        ];
    }
}
