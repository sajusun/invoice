<?php

namespace App\Http\Controllers;

use App\Models\Customers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;

class CustomersController extends Controller
{
    public function customers()
    {
       return  User::find(Auth::id())->customers;
    }

    public function total_customers()
    {
       return User::find(Auth::id())->customers()->count();
    }
}
