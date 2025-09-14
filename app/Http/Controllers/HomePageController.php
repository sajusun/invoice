<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;

class HomePageController extends Controller
{
    public function homePage()
    {
        $subscription= new SubscriptionController();
        $plans=$subscription->plans();
        $user=auth()->user();

        return view('index',compact('plans','user'));
    }

    public function home()
    {
      return view('home');
    }

    public function maintenanceMode(): View
    {
      return view('pages.maintenance');
    }

    public function contact_form()
    {
      return  view('pages.contact');
    }
    public function submit_contact(Request $request){
        return redirect()->route('contact.form')->with('message','Successfully Submitted');
    }
}
