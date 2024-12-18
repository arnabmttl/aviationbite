<?php

namespace App\Http\Requests\Backend;

use Illuminate\Foundation\Http\FormRequest;

class DiscountCreateRequest extends FormRequest
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
            'code' => 'required|string|max:255|unique:discounts',
            'discount_percentage' => 'required_without:discount_amount|nullable|numeric|min:1|max:100',
            'discount_amount' => 'required_without:discount_percentage|nullable|numeric|min:1|lte:maximum_discount',
            'maximum_discount' => 'required|numeric|min:1',
            'valid_from' => 'required|date|after:yesterday',
            'valid_till' => 'required|date|after:valid_from',
            'students' => 'nullable|array',
            'students.*' => 'exists:users,id',
            'courses' => 'nullable|array',
            'courses.*' => 'exists:courses,id',
        ];
    }
}
