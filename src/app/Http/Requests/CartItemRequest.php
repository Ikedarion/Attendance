<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CartItemRequest extends FormRequest
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
            'quantity' => ['required', 'integer', 'min:1']
        ];
    }

    public function messages()
    {
        return [
            'quantity.required' => '数量を入力してください',
            'quantity.integer' => '数量を整数で入力してください',
            'quantity.min' => '数量を1以上で入力してください'
        ];
    }
}
