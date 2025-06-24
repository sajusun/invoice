<?php

namespace App\Http\Controllers;

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
}
