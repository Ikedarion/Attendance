<?php

namespace App\Http\Controllers;

use App\Http\Requests\AttendanceRequest;
use App\Models\Attendance;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Throwable;

class AttendanceController extends Controller
{
    public function index()
    {
        try {
            $all_attendances = Attendance::with('user')->todaySearch()->get();
            $my_attendance = Attendance::userSearch()->todaySearch()->first();

            return response()->json([
                'all_attendances' => $all_attendances,
                'my_attendance' => $my_attendance
            ]);
        } catch (Throwable $e) {
            throw $e;
        }
    }

    public function start()
    {
        try {
            $dt = new Carbon();
            $date = $dt->toDateString();
            $time = $dt->toTimeString();

            Attendance::create([
                'user_id' => Auth::id(),
                'date' => $date,
                'start_time' => $time
            ]);

            return response()->json([
                'message' => '勤務を開始しました'
            ]);
        } catch (Throwable $e) {
            throw $e;
        }
    }

    public function end(Request $request)
    {
        try {
            $dt = new Carbon();
            $time = $dt->toTimeString();

            Attendance::find($request->attendance_id)->update([
                'end_time' => $time
            ]);

            return response()->json([
                'message' => '勤務を終了しました'
            ]);
        } catch (Throwable $e) {
            throw $e;
        }
    }

    public function store(AttendanceRequest $request)
    {
        try {
            $attendance = $request->only(['date', 'start_time', 'end_time']);
            $attendance['user_id'] = Auth::id();

            Attendance::create($attendance);

            return response()->json([
                'message' => '勤怠を作成しました'
            ]);
        } catch (Throwable $e) {
            throw $e;
        }
    }

    public function update(AttendanceRequest $request)
    {
        try {
            $attendance = $request->only(['date', 'start_time', 'end_time']);
            Attendance::find($request->attendance_id)->update($attendance);

            return response()->json([
                'message' => '勤怠を更新しました'
            ]);
        } catch (Throwable $e) {
            throw $e;
        }
    }

    public function destroy(Request $request)
    {
        try {
            Attendance::find($request->attendance_id)->delete();

            return response()->json([
                'message' => '勤怠を削除しました'
            ]);
        } catch (Throwable $e) {
            throw $e;
        }
    }
}
