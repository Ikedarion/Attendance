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
            'date' => 'required|date',
            'clock_in_time' => 'required|date_format:H:i:s',
            'clock_out_time' => 'required|date_format:H:i:s|before_or_equal:23:59:00',
            'break_times.*.break_start_time' => 'required|date_format:H:i:s',
            'break_times.*.break_end_time' => 'required|date_format:H:i:s',
        ];
    }

    public function messages()
    {
        return [
            'date.required' => '日付を入力してください',
            'date.date' => '日付はYYYY-MM-DD形式で入力してください。',
            'clock_in_time.required' => '出勤時間を入力してください。',
            'clock_in_time.date_format' => '出勤時間はHH:MM:SS(時:分:秒)形式で入力してください。',
            'clock_out_time.required' => '退勤時間を入力してください。',
            'clock_out_time.date_format' => '退勤時間はHH:MM:SS(時:分:秒)形式で入力してください。',
            'clock_out_time.before_or_equal' => '退勤時間は23:59:00まで入力してください。',
            'break_times.*.break_start_time.required' => '休憩開始時間を入力してください。',
            'break_times.*.break_end_time.required' => '休憩終了時間を入力してください。',
            'break_times.*.break_start_time.date_format' => '休憩開始時間はHH:MM:SS(時:分:秒)形式で入力してください。',
            'break_times.*.break_end_time.date_format' => '休憩終了時間はHH:MM:SS(時:分:秒)形式で入力してください。',
        ];
    }
}

