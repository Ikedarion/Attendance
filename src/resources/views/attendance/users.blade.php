@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/users.css') }}">
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
<div class="users__content">
    @if(session('message'))
    <div class="alert alert-success" style="color: rgb(39, 39, 39); background-color: #f1f1f1; padding: 15px; margin:0 auto;">
        {{session('message')}}
    </div>
    @endif

    @if ($errors->any())
    <div class="alert alert-danger" style="color: #db2727;  padding: 15px; margin:0 auto; font-size: 18px;">
        エラーが発生しています。ユーザー情報が更新されていません:
    </div>
    @endif

    <div class="users__header">
        従業員一覧
    </div>


    <div class="search-form__items">
        <form class="search-form" action="{{ route('attendance.search') }}" method="get">
            <div class="search-form__text">
                <input class="search-form__text-input" type="text" name="keyword" placeholder="名前や役割を検索してください" value="{{ request('keyword') }}">
            </div>
            <div class="form__button">
                <input class="form__button-submit" type="submit" value="検索">
                <a href="/attendance/users" class="form__button-reset">リセット</a>
            </div>
        </form>
        <div class="users__pagination">
            {{ $users->links('vendor.pagination.bootstrap-4') }}
        </div>
    </div>
    <table class="users__table">
        <tr class="users__row">
            <th class="users__label">ID</th>
            <th class="users__label">お名前</th>
            <th class="users__label">メールアドレス</th>
            <th class="users__label">役割</th>
            <th class="users__label"></th>
            <th class="users__label"></th>
        </tr>
        @foreach($users as $user)
        <tr class="users__row">
            <td class="users__data">{{ $user->id }}</td>
            <td class="users__data">{{ $user->name }}</td>
            <td class="users__data">{{ $user->email }}</td>
            <td class="users__data">
                @if($user->is_admin === 1 )
                管理者
                @else
                一般従業員
                @endif
            </td>
            <td class="users__data">
                <a href="#modal{{$user->id}}" class="user__detail-btn">編集</a>

                <div class="modal" id="modal{{$user->id}}">
                    <div class="modal__inner">
                        <div class="modal__content">
                            <a href="#" class="close" data-dismiss="modal">×</a>
                            <form action="/user/update" method="post" class="modal__detail-form">
                                @csrf
                                @method('PATCH')

                                <div class="modal-form__group">
                                    <label class="label" for="name" class="modal-form__label">お名前</label>
                                    <input type="text" id="name" name="name" value="{{$user->name}}" class="modal-form__text">
                                </div>
                                @error('name')
                                <div class="modal-alert-name" style="color: #e95d5d;">
                                    {{ $message }}
                                </div>
                                @enderror

                                <div class="modal-form__group">
                                    <label class="label" for="email" class="modal-form__label">メールアドレス</label>
                                    <input type="email" id="email" name="email" value="{{$user->email}}" class="modal-form__text">
                                </div>
                                @error('email')
                                <div class="modal-alert-email" style="color: #e95d5d;">
                                    {{ $message }}
                                </div>
                                @enderror

                                <div class="modal-form__group">
                                    <label for="is_admin" class="modal-form__label">
                                        <div class="modal-form__group">
                                            <label class="label" class="modal-form__label">役割</label>
                                            <div>
                                                <input class="modal-form__radio" type="radio" id="user" name="is_admin" value="0" {{ $user->is_admin == 0 ? 'checked' : '' }}>
                                                <label for="user">一般ユーザー</label>
                                                <input class="modal-form__radio" type="radio" id="admin" name="is_admin" value="1" {{ $user->is_admin == 1 ? 'checked' : '' }}>
                                                <label for="admin">管理者</label>
                                            </div>
                                        </div>
                                </div>

                                <input type="hidden" name="id" value="{{ $user->id }}">
                                <input class="modal-form__update-btn btn" type="submit" value="更新">
                            </form>

                            <form action="/user/delete" method="post" class="modal__delete-form">
                                @csrf
                                @method('DELETE')
                                <input type="hidden" name="id" value="{{$user->id}}">
                                <input class="modal-form__delete-btn btn" type="submit" value="削除">
                            </form>
                        </div>
                    </div>
                </div>

            </td>
            <td class="users__data">
                <form action="{{route('attendance.show',['id' => $user->id] )}}" method="get" class="user__data-btn">
                    <input class="user__data-btn-submit" type="submit" value="勤怠ページ">
                    <input class="user__data-btn-submit" type="hidden" name="id" value="{{$user->id}}">
                </form>
            </td>
        </tr>

        @endforeach
    </table>
</div>
@endsection