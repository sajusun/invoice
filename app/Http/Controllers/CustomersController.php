<?php

namespace App\Http\Controllers;

use App\Models\Customers;
use App\Models\Invoices;
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

    public function customer_data($id)
    {
//        $customers = Customers::with('invoices')->where('customers_id',$id)->get();
      return Customers::with('invoices')->findOrFail($id);

      // return User::find(Auth::id())->customers()->where('id', $id)->first();

    }
}
