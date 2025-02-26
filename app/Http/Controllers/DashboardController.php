<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth'); // Only authenticated users can access this controller
    }

    public function dashboard(): View
    {
        $invoice_ctrl = new InvoicesController();
        $invoices = $invoice_ctrl->get_all_invoices();
        $num_of_invoices = $invoice_ctrl->num_of_invoices();
        $total = $invoice_ctrl->sum_of_total();
        $status = $invoice_ctrl->invoice_status();
        session()->flash('success', 'Welcome, ' . Auth::user()->name . '!');

        return view('dashboard', ['num_of_invoices' => $num_of_invoices, 'total' => $total, 'invoices' => $invoices, 'status' => $status]);
    }

    public function customers(): View
    {
        $customer_ctrl = new CustomersController();
        $customers = $customer_ctrl->customers();
        return view('pages.customer', ['customers' => $customers, 'controller' => $customer_ctrl]);
    }

    public function get_customer_data($id): array
    {
        $customer_ctrl = new CustomersController();
        $customer_data = $customer_ctrl->customer_data($id);
        $customer_pending = $customer_ctrl->total_pending($id);
        $customer_revenue = $customer_ctrl->total_revenue($id);
        return compact('customer_data', 'customer_pending', 'customer_revenue');
    }

    public function get_customer_invoice($id): array
    {
        $invoice_ctrl = new InvoicesController();
        $data = $invoice_ctrl->find_invoice($id);
        return $data;

    }

}
