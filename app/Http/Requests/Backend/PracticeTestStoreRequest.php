<?php

namespace App\Http\Requests\Backend;

use Illuminate\Foundation\Http\FormRequest;

class PracticeTestStoreRequest extends FormRequest
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
            'chapter_selected' => 'required|array',
            'chapter_selected.*' => 'required|exists:course_chapters,id',
            'number_of_questions' => 'required|numeric|min:1|max:255',
            'difficulty_level_id' => 'nullable|exists:difficulty_levels,id',
            'question_type_id' => 'nullable|exists:question_types,id'
        ];
    }
}
