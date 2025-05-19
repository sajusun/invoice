<?php

namespace App\Services;

use Illuminate\Support\Facades\Auth;

class UserService
{
    public static function userName()
    {
    return Auth::user()->name;
    }public static function email()
    {
    return Auth::user()->email;
    }

}
