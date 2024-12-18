<?php

namespace App\Http\Requests\Backend;

use Illuminate\Foundation\Http\FormRequest;

// Support Facades
use Illuminate\Support\Facades\Session;

class AddBannerForPageRequest extends FormRequest
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
            'desktop_image' => 'required|image',
            'mobile_image' => 'required|image',
            'banner_text' => 'nullable|string',
            'banner_redirection_url' => 'nullable|string|max:255',
            'banner_button_text' => 'nullable|string|max:255'
        ];
    }
}
