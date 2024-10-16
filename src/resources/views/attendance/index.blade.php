@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/attendance.css')}}">
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
<div class="attendance">

    <p class="attendance__heading">
        @if ($attendances->hasPages())
        {{ $attendances->links('vendor.pagination.custom1') }}
        @else
        {{ \Carbon\Carbon::now()->toDateString() }}
        @endif
    </p>

    <div class="attendance__table">
        <table class="attendance__table-inner">
            <tr class="attendance__row">
                <th class="attendance__label">名前</th>
                <th class="attendance__label">勤務開始</th>
                <th class="attendance__label">勤務終了</th>
                <th class="attendance__label">休憩時間</th>
                <th class="attendance__label">勤務時間</th>
            </tr>
            @foreach($attendances as $attendance)
            <tr class="attendance__row">
                <td class="attendance__data">{{$attendance->user->name}}</td>
                <td class="attendance__data">
                    {{\Carbon\Carbon::parse($attendance->clock_in_time)->format('H:i:s')}}
                </td>
                <td class="attendance__data">
                    @if($attendance->clock_out_time){{\Carbon\Carbon::parse($attendance->clock_out_time)->format('H:i:s')}}
                    @else
                    00:00:00
                    @endif
                </td>
                <td class="attendance__data">{{\Carbon\Carbon::parse($attendance->total_break_time)->format('H:i:s')}}</td>
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
            </tr>
            @endforeach
        </table>
        <div>{{ $attendances->links('vendor.pagination.bootstrap-4') }}</div>
    </div>
</div>



@endsection