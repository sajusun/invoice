<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;

class HomePageController extends Controller
{
    public function home(): View
    {
        $plans = Plan::all();
        $user = Auth::user();

        return view('home', compact('plans', 'user'));
    }

    public function homePage(): View
    {
        return $this->home();
    }

    public function maintenanceMode(): View
    {
        return view('pages.maintenance');
    }

    public function contact_form(): View
    {
        return view('pages.contact');
    }

    public function submit_contact(Request $request): RedirectResponse
    {
        $request->validate([
            'name'    => 'required|string|max:255',
            'email'   => 'required|email|max:255',
            'message' => 'required|string|max:2000',
        ]);

        return redirect()->route('contact.form')->with('message', 'Thank you! Your message has been received.');
    }
}
