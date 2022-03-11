<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AttendanceRequest extends FormRequest
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
            'date' => ['required', 'date', 'before_or_equal:today'],
            'start_time' => ['required', 'date_format:H:i:s'],
            'end_time' => ['required', 'date_format:H:i:s', 'after:start_time']
        ];
    }

    public function messages()
    {
        return [
            'date.required' => '日付を入力してください',
            'date.date' => '有効な日付を入力してください',
            'date.before_or_equal' => '本日以前の日付を入力してください',
            'start_time.required' => '開始時刻を入力してください',
            'start_time.date_format' => '有効な時間を入力してください',
            'end_time.required' => '終了時刻を入力してください',
            'end_time.date_format' => '有効な時間を入力してください',
            'end_time.after' => '開始時刻より後の時刻を入力してください'
        ];
    }
}
