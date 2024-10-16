@extends('layouts.app')

@section('content')
<style>
    .container {
        margin: 0 auto;
        text-align: center;
        padding-top: 37px;
        height: 690px;
        background-color: #f4f4f4;
    }

    h1 {
        font-size: 24px;
        color: #333;
    }

    p {
        font-size: 16px;
        color: #555;
    }

    .btn-primary {
        margin-top: 30px;
        background-color: #007bff;
        color: white;
        padding: 10px 20px;
        border: none;
        border-radius: 5px;
    }
</style>

<div class="container">
    <h1>メール認証が必要です</h1>
    <p>登録したメールアドレスに確認用のリンクを送信しました。<br>メールを確認し、リンクをクリックして認証を完了してください。</p>


    @if (session('message'))
    <div class="alert alert-success">
        {{ session('message')}}
    </div>
    @endif

    <form method="POST" action="{{route('verification.send')}}">
        @csrf
        <button type="submit" class="btn-primary">
            認証メールを再送信する
        </button>
    </form>
</div>
@endsection