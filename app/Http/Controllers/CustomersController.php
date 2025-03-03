<?php

namespace App\Http\Controllers;

use App\Models\Customers;
use App\Models\Invoices;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use function Pest\Laravel\json;

class CustomersController extends Controller
{
    public function customers()
    {
       return  User::find(Auth::id())->customers;
    }
//dont remove function here
    public function total_customers()
    {
       return User::find(Auth::id())->customers()->count();
    }
    public function total_revenue($id)
    {
        return User::find(Auth::id())->invoices->where('customer_id', $id)->sum('total_amount');
    }
    public function total_pending($id)
    {
        return User::find(Auth::id())->invoices->where('customer_id',$id)->where('status', 'pending')->count();
    }

    public function customer_data($id)
    {
      return Customers::with('invoices')->findOrFail($id);
    }

    public function get_customer_by_invoiceId($invoice_id)
    {
        return Customers::with('invoices')->where('invoice_id', $invoice_id)->first();

    }

    public function find_by_number($number): JsonResponse
    {
        return response()->json([
            'number' => $number,
        ]);
    }
}
