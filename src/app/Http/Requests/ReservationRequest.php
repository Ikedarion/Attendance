<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReservationRequest extends FormRequest
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
            'date' => ['required', 'date', 'after:today'],
            'time' => ['required', 'date_format:H:i'],
            'number' => ['required', 'integer']
        ];
    }

    public function messages()
    {
        return [
            'date.required' => '日付を入力してください',
            'date.date' => '有効な日付を入力してください',
            'date.after' => '本日より後の日付を入力してください',
            'time.required' => '時刻を入力してください',
            'time.date_format' => '有効な時間を入力してください',
            'number.required' => '人数を入力してください',
            'number.integer' => '人数を整数で入力してください',
        ];
    }
}
