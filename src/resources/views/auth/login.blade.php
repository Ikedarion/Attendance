@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/auth/login.css') }}">
@endsection

@section('content')
<div class="login__content">
    <div class="login__header">
        <h3>ログイン</h3>
    </div>
    <form class="form" action="/login" method="post">
        @csrf
        <div class="form__group">
            <div class="form__text">
                <input class="form__text-input" type="email" name="email" placeholder="メールアドレス" value="{{ old('email') }}" />
            </div>
            <div class="form__error">
                @error('email')
                <div class="form__error-message">{{ $message }}</div>
                @enderror
            </div>
        </div>
        <div class="form__group">
            <div class="form__text">
                <input class="form__text-input" type="password" name="password" placeholder="パスワード" value="{{ old('password') }}" />
            </div>
            <div class="form__error">
                @error('password')
                <div class="form__error-message">{{ $message }}</div>
                @enderror
            </div>
        </div>
        <div class="form__button">
            <input class="form_button-submit" type="submit" value="ログイン">
        </div>
    </form>
    <div class="register__link">
        <p class="register__link-p">アカウントをお持ちでない方はこちらから</p>
        <a class="register__button-submit" href="/register">会員登録</a>
    </div>
</div>
@endsection