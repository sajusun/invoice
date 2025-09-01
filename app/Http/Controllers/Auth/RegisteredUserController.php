<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Controllers\CountryController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProfileController;
use App\Models\Settings;
use App\Models\User;
use App\Models\UserDetail;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
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
        $cc= new  CountryController();
        $countries=$cc->getCountries();
        //dd($country);

        return view('pages.register',compact('countries'));
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
            'country' => ['required', 'string', 'max:255'],

        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
        $this->on_register_run($user);
//        PaymentController::onSignUp($user);
//        Settings::create([
//            'user_id' => $user->id,
//            'company_name' => "Invozen App",
//        ]);
//        UserDetail::create([
//            'user_id' => $user->id,
//            'country' => $request->country,
//        ]);

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

    public static function on_register_run(User $user): void
    {
        PaymentController::onSignUp($user);
        Settings::create([
            'user_id' => $user->id,
            'company_name' => "Invozen App",
        ]);
        UserDetail::create([
            'user_id' => $user->id,
            'country' => request('country')??'',
        ]);
    }

}
