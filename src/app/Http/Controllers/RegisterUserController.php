<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Auth\Events\Registered;
use App\Http\Requests\RegisterRequest;
use Illuminate\Routing\Controller;
use Illuminate\Support\Str;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Laravel\Fortify\Contracts\RegisterResponse;
use Laravel\Fortify\Fortify;
use Illuminate\Foundation\Auth\EmailVerificationRequest;

class RegisterUserController extends Controller
{
    public function store(
        RegisterRequest $request,
        CreatesNewUsers $creator
    ): RegisterResponse {
        if (config('fortify.lowercase_usernames')) {
            $request->merge([
                Fortify::username() => Str::lower($request->{Fortify::username()}),
            ]);
        }

        $user = $creator->create($request->validated());

        event(new Registered($user));

        return app(RegisterResponse::class);
    }


    // メール認証待ちのビューを表示
    public function notice()
    {
        return view('auth.verify-email');
    }

    // メール内のリンクをクリックした際の処理
    public function verify(EmailVerificationRequest $request)
    {
        if ($request->user()->hasVerifiedEmail()) {
            return redirect()->route('home')->with('message', 'すでに認証済みです');
        }

        $request->fulfill();

        return redirect()->route('home')->with('verified', true);
    }

    // 認証メールの再送信
    public function resend(Request $request)
    {
        $request->user()->sendEmailVerificationNotification();

        return back()->with('message', 'Verification link sent!');
    }

}
