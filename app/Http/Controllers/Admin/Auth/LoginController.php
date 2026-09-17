<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        if (Auth::guard('admin')->check()) {
            return redirect()->route('admin.dashboard');
        }

        return view('admin.auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::guard('admin')->attempt($credentials, $request->filled('remember'))) {
            return redirect()->route('admin.dashboard');
        }

        return back()->withErrors([
            'email' => 'Invalid login credentials',
        ]);
    }

    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();

        // Only invalidate the full session if Web User guard is not active
        if (!Auth::guard('web')->check()) {
            $request->session()->invalidate();
        }

        $request->session()->regenerateToken();
        return redirect()->route('admin.login');
    }
}

