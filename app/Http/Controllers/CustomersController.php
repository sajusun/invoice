<?php

namespace App\Http\Controllers;

use App\Models\Customers;
use App\Models\User;
use App\Services\CustomerService;
use App\Services\InvoiceService;
use http\Env\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class CustomersController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'verified']); // Only authenticated users can access this controller
    }

    public function customers()
    {
        return User::find(Auth::id())->customers;
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
        return User::find(Auth::id())->invoices->where('customer_id', $id)->where('status', 'pending')->count();
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

    public function customer_details($id): View
    {
        $customer_ctrl = new CustomersController();
        $customer = $customer_ctrl->get_customer_by_invoiceId($id);
        return view('pages.customers.customers_details', ['customer' => $customer, 'controller' => $customer_ctrl]);
    }

    public function customers_data_update($id): View|RedirectResponse
    {

        if (Request()->isMethod('GET')) {
            return $this->customer_details($id);
        }

        $validated = validator(request()->all(), [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'phone' => ['required', 'numeric', 'digits_between:10,12'],
            'address' => ['required', 'string', 'max:255'],
        ]);
        if ($validated->fails()) {
            return redirect()->back()->with(['message' => $validated->errors()->first(), 'response' => 'error']);
        }
        $user = Auth::user();
        $user = $user->Customers->find($id);
        $user->name = Request()->name;
        $user->email = Request()->email;
        $user->phone = Request()->phone;
        $user->address = Request()->address;
        $user->save();
        return redirect()->back()->with(['message' => 'Update Successfully.', 'response' => 'success']);
    }


}
