<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Throwable;

class UserController extends Controller
{
    public function show()
    {
        try {
            return User::with('attendances')->find(Auth::id());
        } catch (Throwable $e) {
            throw $e;
        }
    }
}
