<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $user = auth()->user();
        $request->user()->fill($request->validated());

        if ($request->hasFile('profile_pic')) {
            $file = $request->file('profile_pic');

            // Generate unique file name
            $filename = time() . '_' . $file->getClientOriginalName();

            // Store in public disk under profile_pics directory
            $file->storeAs('/profile_pics', $filename,'public');

            // Delete old image if exists
            if ($user->profile_pic) {
                Storage::delete('/profile_pics' . $user->profile_pic);
            }

            // Save new image path to database
            $user->profile_pic = $filename;
        }

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

     // $request->user()->save();

        $user->save();
        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }

}
