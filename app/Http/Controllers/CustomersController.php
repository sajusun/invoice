<?php

namespace App\Http\Controllers;

use App\Models\Customers;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class CustomersController extends Controller
{
    public function customer_name(string $id)
    {
       // $customar=Customers::all(['name'])->where(['invoice_number', $id]);
        $name = Customers::find($id,['name']);


        return $name;
    }
}
