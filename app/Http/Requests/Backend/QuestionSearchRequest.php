<?php

namespace App\Http\Requests\Backend;

use Illuminate\Foundation\Http\FormRequest;

class QuestionSearchRequest extends FormRequest
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
            'question_id' => 'nullable|string|max:255',
            'course_id' => 'nullable|exists:courses,id',
            'course_chapter_id' => 'nullable|exists:course_chapters,id',
            'difficulty_level_id' => 'nullable|exists:difficulty_levels,id',
            'question_type_id' => 'nullable|exists:question_types,id',
        ];
    }
}
