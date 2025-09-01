<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class SocialAuthController extends Controller
{
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {

        try {
            $googleUser = Socialite::driver('google')->user();
            //dd($googleUser);
            $user = User::firstOrCreate([
                'email' => $googleUser->getEmail(),
            ], [
                'name' => $googleUser->getName(),
                'profile_pic' => $googleUser->getAvatar(),
                'social_login' => true,
                'password' => '',
            ]);
            if (!$user->hasVerifiedEmail()) {
                $user->markEmailAsVerified();
            }
            RegisteredUserController::on_register_run($user);
            Auth::login($user); //
            return redirect()->route('dashboard'); // Make sure this route exists
        } catch (\Exception $e) {
            return redirect('/login')->with('error', 'Something went wrong. Please try again.');
        }
    }

    public function redirectToFacebook()
    {
        return Socialite::driver('facebook')->redirect();
    }

    public function handleFacebookCallback()
    {
        try{
        $facebookUser = Socialite::driver('facebook')->user();
        $user = User::firstOrCreate([
            'email' => $facebookUser->getEmail(),
        ], [
            'name' => $facebookUser->getName(),
            'profile_pic' => $facebookUser->getAvatar(),
            'social_login' => true,
            'password' => '',
        ]);
            if (!$user->hasVerifiedEmail()) {
                $user->markEmailAsVerified();
            }
RegisteredUserController::on_register_run($user);
        Auth::login($user);

            return redirect()->route('dashboard'); // Make sure this route exists
        } catch (\Exception $e) {
            return redirect('/login')->with('error', 'Something went wrong. Please try again.');
        }
    }
}
