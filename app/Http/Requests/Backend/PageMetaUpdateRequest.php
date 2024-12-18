<?php

namespace App\Http\Requests\Backend;

use Illuminate\Foundation\Http\FormRequest;

// Support Facades
use Illuminate\Support\Facades\Session;

class PageMetaUpdateRequest extends FormRequest
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
        Session::flash('selected_tab', 'pagemeta');

        return [
            'meta_title' => 'nullable|string|max:255',
            'meta_keywords' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:255'
        ];
    }
}
