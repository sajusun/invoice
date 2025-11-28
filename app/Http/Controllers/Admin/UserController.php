<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Settings;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules;


class UserController extends Controller
{
    public function userData(Request $request, $id)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255',
                Rule::unique(User::class)->ignore($id),],
        ]);
        $user = User::findOrFail($id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->email_verified_at = null;
        if (!empty($request->email_verified_at))
            $user->email_verified_at = now()->toDateString();

        $user->save();
        return redirect()->back()->with('message', 'User data updated successfully');

    }

    public function userPassword(Request $request,$id)
    {
        $request->validate([
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::findOrFail($id);
        $user->password = Hash::make($request->password);
        $user->save();
        return redirect()->back()->with('message', 'User password updated successfully');
    }

    public function userCompanyData(Request $request,$id)
    {
         $request->validate([
            'company_name' => 'required|string|max:255',
            'company_email' => ['string', 'lowercase', 'email', 'max:255'],
            'company_phone' => 'nullable|string|max:20',
            'company_address' => 'nullable|string|max:500',
            'default_currency' => 'required|string|max:10',
        ]);
        $user = User::findOrFail($id);

        Settings::where('user_id', $user->id)->update([
            'company_name' => $request->company_name,
            'company_email' => $request->company_email,
            'company_phone' => $request->company_phone,
            'company_address' => $request->company_address,
            'default_currency' => $request->default_currency,]
        );
        return redirect()->back()->with('message', 'Company data updated successfully');

    }
}
