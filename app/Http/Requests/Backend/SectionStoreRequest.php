<?php

namespace App\Http\Requests\Backend;

use Illuminate\Foundation\Http\FormRequest;

class SectionStoreRequest extends FormRequest
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
        $validation['section_view_id'] = 'required|exists:section_views,type';
        $validation['margin_top'] = 'required|numeric';
        $validation['margin_bottom'] = 'required|numeric';

        switch ($this->section_view_id) {
            case 1: $validation['title'] = 'required|string|max:255';
                    $validation['desktop_image'] = 'required|image';
                    $validation['mobile_image'] = 'required|image';
                    $validation['banner_text'] = 'nullable|string';
                    $validation['banner_redirection_url'] = 'nullable|url|max:255';
                    $validation['banner_button_text'] = 'nullable|string|max:255';
                    break;

            case 2: $validation['title'] = 'required|string|max:255';
                    $validation['redirection_url'] = 'required|url|max:255';
                    $validation['description'] = 'required|string';
                    break;

            case 3: 
            case 6: $validation['title'] = 'required|string|max:255';
                    $validation['section_image'] = 'required|image';
                    $validation['redirection_url'] = 'required|url|max:255';
                    $validation['description'] = 'required|string';
                    break;

            case 7: $validation['collection_id'] = 'required|exists:collections,id';
                    break;

            case 8: 
            case 11: $validation['title'] = 'required|string|max:255';
                     $validation['section_image'] = 'required|image';
                     $validation['description'] = 'required|string';
                     break;

            case 9:
            case 10: $validation['title'] = 'required|string|max:255';
                     $validation['description'] = 'required|string';
                     break;

            case 12: $validation['title'] = 'required|string|max:255';
                     $validation['description'] = 'required|string';
                     $validation['faq_question'] = 'required|string';
                     $validation['faq_answer'] = 'required|string';
                     break;
        }

        return $validation;
    }
}
