<?php

namespace App\Http\Requests\Backend;

use Illuminate\Foundation\Http\FormRequest;

// Support Facades
use Illuminate\Support\Facades\Session;

class PageDetailsUpdateRequest extends FormRequest
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
            'title' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:pages,slug,'.$this->segment(3)
        ];
    }
}
