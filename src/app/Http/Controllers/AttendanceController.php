<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Attendance;
use App\Models\User;
use App\Http\Requests\AttendanceRequest;
use Carbon\Carbon;

class AttendanceController extends Controller
{
    public function index(Request $request)
    {
        $today = Carbon::today();

        $attendances = Attendance::with('user')
                                ->whereDate('date', $today)
                                ->paginate(5);

        $date = Carbon::now();

        return view('attendance.index',compact('attendances','date'));
    }

    public function list()
    {
        $users = User::with('attendances')->paginate(9);
        return view('attendance.users', compact('users'));
    }

    public function search(Request $request)
    {
        $users = User::with('attendances')
                ->KeywordSearch($request->keyword)
                ->paginate(9)
                ->appends($request->query());
        $attendances = Attendance::all();

        return view('attendance.users', compact('users', 'attendances'));
    }

    public function updateUser(Request $request) {
        $user = User::find($request->id);
        $userData = $request->only('name', 'email', 'is_admin');

        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email,' . $user->id,
        ], [
            'name.required' => 'お名前を入力してください。',
            'email.required' => 'メールアドレスを入力してください。',
            'email.email' => '有効なメールアドレスを入力してください。',
            'email.unique' => 'このメールアドレスはすでに使用されています。',
        ]);


        $user->update($userData);

        return redirect()->back()->with('message', '勤怠情報が更新されました');
    }

    public function deleteUser(Request $request)
    {
        User::find($request->id)->delete();;
        return redirect('/attendance/users')->with('message', 'ユーザー情報が削除されました');
    }

    public function show(Request $request)
    {
        $userID = $request->input('id');

        $year = $request->input('year', date('Y'));
        $month = $request->input('month', date('m'));

        // 指定した年と月の1日から月末日までの範囲を取得
        $startDate = Carbon::createFromDate($year, $month, 1);
        $endDate = $startDate->copy()->endOfMonth();


        $attendances = Attendance::whereNotNull('clock_out_time')
                    ->with(['user', 'break_times'])
                    ->where('user_id', $userID)
                    ->whereBetween('date', [$startDate, $endDate]) // 年と月でフィルタリング
                    ->orderBy('date', 'desc')
                    ->get();

        return view('attendance.attendance', compact('attendances', 'userID','year', 'month'));
    }

    public function update(AttendanceRequest $request)
    {
        $attendance = Attendance::find($request->id);
        $date = $request->input('date');

        $clockInTime = Carbon::createFromFormat('Y-m-d H:i:s', $date . ' ' . $request->input('clock_in_time'));
        $clockOutTime = Carbon::createFromFormat('Y-m-d H:i:s', $date . ' ' . $request->input('clock_out_time'));


        $attendanceData = [
            'date' => $date,
            'clock_in_time' => $clockInTime,
            'clock_out_time' => $clockOutTime,
        ];
        $attendance->update($attendanceData);

        $breakTimes = $attendance->break_times;

        if($breakTimes->isNotEmpty()) {
            $totalBreakTime = 0;

            foreach ($breakTimes as $breakTime) {
                // 各BreakTimeレコードをIDで取得
                $breakTimeData = $request->input('break_times')[$breakTime->id] ?? null;

                if ($breakTimeData) {
                    $breakStartTime = Carbon::createFromFormat('Y-m-d H:i:s', $date . ' ' . $breakTimeData['break_start_time']);
                    $breakEndTime = Carbon::createFromFormat('Y-m-d H:i:s', $date . ' ' . $breakTimeData['break_end_time']);

                    $totalBreakTime += $breakEndTime->diffInMinutes($breakStartTime);

                    // BreakTimeレコードを更新
                    $breakTime->update([
                        'break_start_time' => $breakStartTime,
                        'break_end_time' => $breakEndTime,
                    ]);
                }
            }
            $attendance->update(['total_break_time' => $totalBreakTime]);
        }

        return redirect()->back()->with('message', '勤怠情報が更新されました');
    }

    public function delete(Request $request)
    {
        Attendance::find($request->id)->delete();;
        return redirect()->back()->with('message', '勤怠情報が削除されました');
    }

}
