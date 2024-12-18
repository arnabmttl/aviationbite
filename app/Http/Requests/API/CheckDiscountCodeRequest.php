<?php

namespace App\Http\Requests\API;

use Illuminate\Foundation\Http\FormRequest;

class CheckDiscountCodeRequest extends FormRequest
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
            'discount_code' => 'required|string|min:3|max:255|exists:discounts,code',
            'slug' => 'required|string|min:3|max:255|exists:courses',
            'username' => 'required|string|min:3|max:255|exists:users'
        ];
    }
}
