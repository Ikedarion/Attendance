@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/user-attendance.css')}}">
@endsection

@section('link')
<form action="/" method="get">
    <input class="home__link" type="submit" value="ホーム">
</form>
<form action="/logout" method="post">
    @csrf
    <input class="logout__link" type="submit" value="ログアウト">
</form>
@endsection

@section('content')
<div class="attendance__content">
    @if(session('message'))
    <div class="alert alert-success">
        {{session('message')}}
    </div>
    @endif

    @if ($errors->any())
    <div class="alert alert-danger">
        入力に誤りがあります。勤怠情報が更新されていません。
    </div>
    @endif

    @if($attendances->isEmpty())
    <div class="alert alert-danger">指定された月の勤怠記録はありません。</div>
    @endif


    @php
    $user = App\Models\User::find($userID);
    @endphp
    <p class="user-name">{{ $user->name }}さんの勤怠記録</p>

    <div class="month-selector">
        <form action="{{ route('attendance.show', ['id' => $userID,'year' => $year, 'month' => $month]) }}" method="GET">
            <input type="hidden" name="id" value="{{ $userID }}">
            <select name="year" id="year" onchange="this.form.submit()" style="color: #6f6f6f; border: 1px solid #7f7f7f">
                @for ($y = 2020; $y <= date('Y'); $y++) <!-- 2020年から現在の年まで -->
                    <option value=" {{ $y }}" {{ $y == $year ? 'selected' : '' }}>
                        {{ $y }}年
                    </option>
                    @endfor
            </select>
            <select name="month" id="month" onchange="this.form.submit()" style="color: #6f6f6f; border: 1px solid #7f7f7f">
                @for ($m = 1; $m <= 12; $m++)
                    <option value=" {{ $m }}" {{ $m == $month ? 'selected' : '' }}>
                    {{ $m }}月
                    </option>
                    @endfor
            </select>
        </form>
    </div>

    <table class="attendance-table">
        <tr class="attendance__row">
            <th class="attendance__label">日付</th>
            <th class="attendance__label">出勤時間
            </th>
            <th class="attendance__label">退勤時間</th>
            <th class="attendance__label">休憩時間</th>
            <th class="attendance__label">勤務時間</th>
            <th class="attendance__label"></th>
        </tr>
        @foreach($attendances as $attendance)
        <tr class="attendance__row">
            <td class="attendance__data">{{$attendance->date}}</td>
            <td class="attendance__data">
                {{\Carbon\Carbon::parse($attendance->clock_in_time)->format('H:i:s')}}
            </td>
            <td class="attendance__data">{{\Carbon\Carbon::parse($attendance->clock_out_time)->format('H:i:s')}}</td>
            <td class="attendance__data">
                {{ str_pad(floor($attendance->total_break_time / 60), 2, '0', STR_PAD_LEFT) }}:{{ str_pad(floor($attendance->total_break_time % 60), 2, '0', STR_PAD_LEFT) }}:00
            </td>
            <td class="attendance__data">
                @if($attendance->clock_out_time)
                @php
                $workingDuration = \Carbon\Carbon::parse($attendance->clock_out_time)->diffInSeconds(\Carbon\Carbon::parse($attendance->clock_in_time));
                $breakDuration = $attendance->total_break_time * 60;
                $totalWorkingSeconds = $workingDuration - $breakDuration;
                @endphp
                {{ str_pad(floor($totalWorkingSeconds / 3600), 2, '0', STR_PAD_LEFT) }}:{{ str_pad(floor($totalWorkingSeconds % 3600 / 60), 2, '0', STR_PAD_LEFT) }}:{{ str_pad($totalWorkingSeconds % 60, 2, '0', STR_PAD_LEFT) }}
                @else
                00:00:00
                @endif
            </td>
            <td class="attendance__data">
                <a href="#modal{{$attendance->id}}" class="user__detail-btn">編集</a>

                <div class="modal" id="modal{{$attendance->id}}">
                    <div class="modal__inner">
                        <div class="modal__content">
                            <a href="#" class="close">×</a>
                            <form action="/update" method="post" class="modal__detail-form">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="id" value="{{ $attendance->id }}">
                                <div class="modal__group">
                                    <div class="modal-form__group">
                                        <label class="label" for="date_{{ $attendance->id }}" style="margin-right: 61px;">日付</label>
                                        <input type="text" id="date_{{ $attendance->id }}" name="date_{{ $attendance->id }}" value="{{ old('date_' . $attendance->id, $attendance->date) }}" class="modal-form__text">
                                    </div>
                                    <div class="modal-form__group">
                                        <label class="label" for="clock_in_time_{{ $attendance->id }}" style="margin-right: 31px;">出勤時間</label>
                                        <input type="text" id="clock_in_time_{{ $attendance->id }}" name="clock_in_time_{{ $attendance->id }}" value="{{ old('clock_in_time_' . $attendance->id, \Carbon\Carbon::parse($attendance->clock_in_time)->format('H:i:s')) }}" class="modal-form__text">
                                    </div>
                                    <div class="modal-form__group">
                                        <label class="label" for="clock_out_time_{{ $attendance->id }}" style="margin-right: 31px;">退勤時間</label>
                                        <input type="text" id="clock_out_time_{{ $attendance->id }}" name="clock_out_time_{{ $attendance->id }}" value="{{ old('clock_out_time_' . $attendance->id, \Carbon\Carbon::parse($attendance->clock_out_time)->format('H:i:s')) }}" class="modal-form__text">
                                    </div>
                                </div>
                                @error("date_{$attendance->id}")
                                <div class="modal-alert" style="color: #db2727; font-weight: bold;">
                                    {{ $message }}
                                </div>
                                @enderror
                                @error("clock_in_time_{$attendance->id}")
                                <div class="modal-alert" style="color: #db2727; font-weight: bold;">
                                    {{ $message }}
                                </div>
                                @enderror
                                @error("clock_out_time_{$attendance->id}")
                                <div class="modal-alert" style="color: #db2727; font-weight: bold;">
                                    {{ $message }}
                                </div>
                                @enderror
                                <div class="modal__group-break">
                                    @foreach($attendance->break_times as $break_time)
                                    <div class="modal__group">
                                        <div class="modal-form__group">
                                            <label class="label" for="break_start_time_{{$break_time->id}}">休憩開始時間</label>
                                            <input type="text" id="break_start_time_{{$break_time->id}}" name="break_times[{{$break_time->id}}][break_start_time]" value="{{ old('break_times.' . $break_time->id . '.break_start_time', \Carbon\Carbon::parse($break_time->break_start_time)->format('H:i:s')) }}" class="modal-form__text">
                                        </div>

                                        <div class="modal-form__group">
                                            <label class="label" for="break_end_time_{{$break_time->id}}">休憩終了時間</label>
                                            <input type="text" id="break_end_time_{{$break_time->id}}" name="break_times[{{$break_time->id}}][break_end_time]" value="{{ old('break_times.' . $break_time->id . '.break_end_time', \Carbon\Carbon::parse($break_time->break_end_time)->format('H:i:s')) }}" class=" modal-form__text">
                                        </div>
                                    </div>
                                    @error("break_times.$break_time->id.break_start_time")
                                    <div class="modal-alert" style="color: #db2727; font-weight: bold;">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                    @error("break_times.$break_time->id.break_end_time")
                                    <div class="modal-alert" style="color: #db2727; font-weight: bold;">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                    @endforeach

                                </div>
                                <input class="modal-form__update-btn btn" type="submit" value="更新">
                            </form>

                            <form action="/delete" method="post" class="modal__delete-form">
                                @csrf
                                @method('DELETE')
                                <input type="hidden" name="id" value="{{$attendance->id}}">
                                <input class="modal-form__delete-btn btn" type="submit" value="削除">
                            </form>
                        </div>
                    </div>
                </div>
            </td>
        </tr>
        @endforeach
    </table>

</div>
@endsection