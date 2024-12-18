<?php

namespace App\Http\Requests\Backend;

use Illuminate\Foundation\Http\FormRequest;

class SectionViewEditRequest extends FormRequest
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
            'type' => 'required|numeric|min:1|unique:section_views,type,'.$this->segment(3),
            'name' => 'required|string|max:255|unique:section_views,name,'.$this->segment(3),
            'content' => 'required|string'
        ];
    }
}
