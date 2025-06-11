<?php

namespace App\Http\Controllers;

use App\Models\Customers;
use App\Models\User;
use App\Services\CustomerService;
use App\Services\InvoiceService;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;

class CustomersController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth','verified']); // Only authenticated users can access this controller
    }
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

    public function get_customer_by_invoiceId($customer_id)
    {
        return Customers::with('invoices')->where('id', $customer_id)->first();

    }

    public function find_by_number($number): JsonResponse
    {
        return response()->json([
            'number' => $number,
        ]);
    }
    public function delete_customer($id)
    {

        $deleted = CustomerService::delete_customer($id);

        if ($deleted) {
            return redirect()->back()->with(['message' => 'Client Delete Successfully.', 'response' => 'success']);
        } else {
            return redirect()->back()->with(['message' => 'Failed.', 'response' => 'error']);
        }
    }

}
