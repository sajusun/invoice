<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Settings;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('pages.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
        Settings::create([
            'user_id' => $user->id,
            'company_name' => $user->name . "Invozen App",
        ]);
//        session()->flash('signup_success', $user->email);
        event(new Registered($user));
        return redirect()->route('signup.success',$user->email)->with($user->email,
            'Registration success! Please check your email to verify.');

//        return redirect(route('register',
//            ['message'=>'registered successfully! Please check your email to verify.'],
//            absolute: false));

//        return response()->json(['message' => 'User registered successfully! Please check your email to verify.']);

//        Auth::login($user);
//
//        return redirect(route('dashboard', absolute: false));
    }

    public function signup_success($email)
    {
        if (session()->has($email)) {
            return view('auth.register_success',compact('email'));
        } else {
            return redirect()->route('register');
        }
    }
}
