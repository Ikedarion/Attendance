@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/auth/register.css') }}">
@endsection

@section('content')
<div class="register__content">
    <div class="register-form__heading">
        <p>会員登録</p>
    </div>
    <form class="form" action="/register" method="post">
        @csrf
        <div class="form__group">
            <div class="form__text">
                <input class="form__text-input" type="text" name="name" placeholder="名前" value="{{ old('name') }}" />
            </div>
            <div class="form__error">
                @error('name')
                <div class="form__error-message">{{ $message }}</div>
                @enderror
            </div>
        </div>
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
        <div class="form__group">
            <div class="form__text">
                <input class="form__text-input" type="password" name="password_confirmation" placeholder="確認用パスワード" />
            </div>
            <div class="form__error">
                @error('password_confirmation')
                <div class="form__error-message">{{ $message }}</div>
                @enderror
            </div>
        </div>
        <div class="form__button">
            <input class="form__button-submit" type="submit" value="会員登録">
        </div>
    </form>
    <div class="login__link">
        <p class="login__link-p">アカウントをお持ちの方はこちら</p>
        <a class="login__button-submit" href="/login">ログイン</a>
    </div>
</div>
@endsection