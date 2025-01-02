<?php

namespace App\Http\Requests\Backend;

use Illuminate\Foundation\Http\FormRequest;

class CourseStoreRequest extends FormRequest
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
            'meta_title' => 'nullable|string|max:255',
            'meta_keywords' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:255',
            'topics' => 'required|array',
            'topics.*' => 'exists:topics,id',
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:courses',
            'price' => 'required|numeric|min:0',
            'special_price' => 'required|numeric|lt:price',
            'valid_for' => 'required|numeric|min:1',
            'is_active' => 'required|in:0,1',
            'number_of_tests' => 'required|numeric|min:0',
            'video_url' => 'nullable|url',
            'thumbnail_image' => 'nullable|image',
            'short_description' => 'required',
            'description' => 'required',
        ];
    }
}
