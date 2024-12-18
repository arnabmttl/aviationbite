<?php

namespace App\Http\Requests\Backend;

use Illuminate\Foundation\Http\FormRequest;

// Support Facades
use Illuminate\Support\Facades\Session;

class AddFaqRequest extends FormRequest
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
        Session::flash('selected_tab', 'sectioncontent');
        
        return [
            'faq_question' => 'required|string',
            'faq_answer' => 'required|string'
        ];
    }
}
