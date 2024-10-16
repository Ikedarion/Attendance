@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/index.css')}}">
@endsection

@section('link')
@if(Auth::check() && Auth::user()->is_admin === 1)
<form action="/attendance" method="get">
    <input class="date__link" type="submit" value="日付一覧">
</form>
<form action="/attendance/users" method="get">
    <input class="users__link" type="submit" value="ユーザーー覧">
</form>
@endif
<form action="/logout" method="post">
    @csrf
    <input class="logout__link" type="submit" value="ログアウト">
</form>
@endsection

@section('content')
<div class="attendance-form">
    <div class="alert alert-info">
        {{ Auth::user()->name }}さんお疲れ様です！
    </div>

    @if(session('message'))
    <div class="alert alert-success">
        {{session('message')}}
    </div>
    @endif

    @if(session('error'))
    <div class="alert alert-danger" style="color: rgb(214, 68, 68);">
        {{session('error')}}
    </div>
    @endif

    <div class="attendance-form__inner">
        <div class="form__group">
            @if($attendance && $attendance->clock_out_time === null)
            <!-- 出勤中なので出勤ボタンを無効化 -->
            <form class="form" action="{{route('clock-in')}}" method="post">
                <input class="attendance-form__btn-submit" type="submit" name="clock_in_time" value="勤務開始" disabled>
            </form>
            @else
            <form class="form" action="{{route('clock-in')}}" method="post">
                @csrf
                <input class="attendance-form__btn-submit" type="submit" name="clock_in_time" value="勤務開始">
            </form>
            @endif


            @if($break && $break->break_start_time !== null && $break->break_end_time === null)
            <!-- 休憩中なので、退勤ボタンを無効化 -->
            <form class="form" action="{{route('clock-out')}}" method="post">
                <input class="attendance-form__btn-submit" type="submit" name="clock_out_time" value="勤務終了" disabled>
            </form>
            @else
            <form class="form" action="{{route('clock-out')}}" method="post">
                @csrf
                <input class="attendance-form__btn-submit" type="submit" name="clock_out_time" value="勤務終了">
            </form>
            @endif
        </div>


        <div class="form__group">
            @if($break && $break->break_start_time !== null && $break->break_end_time === null )
            <form class="form" action="{{route('break.start')}}" method="post">
                <input class="attendance-form__btn-submit" type="submit" name="break_start_time" value="休憩開始" disabled>
            </form>
            @else
            <form class="form" action="{{route('break.start')}}" method="post">
                @csrf
                <input class="attendance-form__btn-submit" type="submit" name="break_start_time" value="休憩開始">
            </form>
            @endif

            <form class="form" action="{{ route('break.end') }}" method="post">
                @csrf
                <input class="attendance-form__btn-submit" type="submit" name="break_end_time" value="休憩終了">
            </form>
        </div>
    </div>
    @endsection