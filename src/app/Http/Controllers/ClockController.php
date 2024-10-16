<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Attendance;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\BreakTime;
use Illuminate\Support\Facades\Auth;



class ClockController extends Controller
{
    public function index()
    {
        $attendance = Attendance::where('user_id', Auth::id())
            ->whereDate('clock_in_time', today())
            ->first();

        $break = BreakTime::where('user_id', Auth::id())
            ->whereDate('created_at', today())
            ->whereNull('break_end_time')
            ->first();


        return view('index',compact('attendance','break'));
    }

    public function clockIn()
    {
        $userId = auth()->id();
        $date = Carbon::now();

        $existingAttendance = Attendance::where('user_id', $userId)
        ->whereDate('date', $date)
        ->first();

        if ($existingAttendance) {
            return back()->with('error', today()->format('m月d日') . 'の出勤はすでに登録されています。');
        }


        Attendance::create([
            'user_id' => $userId,
            'date' => $date,
            'clock_in_time' => Carbon::now(),
        ]);

        return redirect()->back()->with('message', '出勤時間が登録されました');

    }



    public function clockOut()
    {
        $userId = auth()->id();
        $current_time = Carbon::now();

        $attendance = Attendance::where('user_id', $userId)
            ->whereNull('clock_out_time')
            ->first();

        // 出勤記録が存在しない場合の処理
        if (!$attendance) {
            return redirect()->back()->with('error', '出勤記録が存在しません。');
        }

        $clockInTime = Carbon::parse($attendance->clock_in_time); // ここで取得

        // トランザクション内で使用する変数を明示的に渡す
        DB::transaction(function () use ($attendance, $current_time, $clockInTime) {
            if ($clockInTime->isSameDay($current_time)) {
                // 同じ日に退勤処理
                $attendance->clock_out_time = $current_time;
                $attendance->save();
            } else {
                // 日を跨ぐ場合の処理
                $clock_out =
                $clockInTime->copy()->endOfDay()->subMinute(1);
                $attendance->clock_out_time = $clock_out;
                $attendance->save();

                // 翌日の出勤を自動的に記録
                $nextDay =
                $clockInTime->copy()->addDay();
                Attendance::create([
                    'user_id' => $attendance->user_id,
                    'date' => $nextDay->toDateString(),
                    'clock_in_time' =>
                    $nextDay->startOfDay(),
                ]);

                // 2日目の退勤処理
                $newAttendance = Attendance::where('user_id', $attendance->user_id)
                    ->where('date', $nextDay->toDateString())
                    ->first();

                if ($newAttendance) {
                    $newAttendance->clock_out_time = $current_time;
                    $newAttendance->save();
                }
            }
        });

        return redirect()->back()->with('message', '退勤処理が完了しました');
    }



    public function breakStart()
    {
        $userId = auth()->id();
        $current_time = Carbon::now();

        DB::beginTransaction();

        try {
            $attendance = Attendance::where('user_id', $userId)
                ->whereNull('clock_out_time')
                ->first();

            if ($attendance) {
                $existingBreak = BreakTime::where('attendance_id', $attendance->id)
                    ->whereNull('break_end_time')
                    ->first();

                // 休憩中でない場合は新しい休憩を開始
                if (!$existingBreak) {
                    BreakTime::create([
                        'user_id' => $userId,
                        'attendance_id' => $attendance->id,
                        'break_start_time' => $current_time,
                    ]);
                DB::commit();

                return redirect()->back()->with('message', '休憩が開始されました');
                } else {
                    return redirect()->back()->with('error', 'すでに休憩中です。');
                }
            }
            DB::rollBack();
            return redirect()->back()->with('error', '出勤記録が存在しません。');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'エラーが発生しました');
        }
    }



    public function breakEnd()
    {
        $userId = auth()->id();
        $current_time = Carbon::now();

        DB::beginTransaction();

        try {
            $attendance = Attendance::where('user_id', $userId)
                ->whereNull('clock_out_time')
                ->first();

            if (!$attendance) {
                return redirect()->back()->with('error', '出勤記録が存在しません。');
            }

            $breakTime = BreakTime::where('attendance_id', $attendance->id)
                            ->whereNull('break_end_time')
                            ->orderBy('break_start_time', 'desc')
                            ->first();


            if ($breakTime) {
                $breakTime->update([
                    'break_end_time' => $current_time,
                ]);

                $breakStart = Carbon::parse($breakTime->break_start_time);

                if($breakStart->isSameDay($current_time)) {
                    $breakDuration = $breakStart->diffInMinutes($current_time);
                }else {
                    $breakDuration = $breakStart->diffInMinutes($breakStart->copy()->endOfDay()) + Carbon::today()->diffInMinutes($current_time);
                }

                $attendance->total_break_time += $breakDuration;
                $attendance->save();

                DB::commit();

                return redirect()->back()->with('message', '休憩が終了しました');
            } else {
                return redirect()->back()->with('error', '休憩が開始されていません。');
            }
        } catch (\exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error','エラーが発生しました');
        }
    }

}

