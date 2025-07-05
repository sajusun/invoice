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

    public function maintenanceMode(): View
    {
      return view('pages.maintenance');
    }
}
