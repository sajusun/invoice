<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\InvoiceService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth','verified']); // Only authenticated users can access this controller
    }



    public function dashboard(): View
    {
        $invoice_ctrl = new InvoicesController();

        $invoices = $invoice_ctrl->get_all_invoices();
        $num_of_invoices = $invoice_ctrl->num_of_invoices();
        $total = $invoice_ctrl->sum_of_total();
        $due = $invoice_ctrl->sum_of_due();
        $pending = $invoice_ctrl->invoice_status();
        $currency = InvoiceService::currency();
        $canceled = $invoice_ctrl->invoice_status('cancelled');
        $paid = $invoice_ctrl->invoice_status('paid');
        return view('dashboard', ['num_of_invoices' => $num_of_invoices, 'total' => $total,'due'=>$due,
            'invoices' => $invoices, 'pending' => $pending,'canceled'=>$canceled,'paid'=>$paid,'currency'=>$currency,'plans'=>$plans]);
    }

    public function customers(): View
    {
        $customer_ctrl = new CustomersController();
        $customers = $customer_ctrl->customers();
        return view('pages.customers.customers_list', ['customers' =>  $customers, 'controller' => $customer_ctrl]);
    }

//    public function customer_details($id)
//    {
//        $customer_ctrl = new CustomersController();
////        $customer = $customer_ctrl->get_customer_by_invoiceId($id);
////        return view('pages.customers.customers_details', ['customer' =>  $customer, 'controller' => $customer_ctrl]);
//      return  $customer_ctrl->customer_details($id);
//
//    }

    public function get_customers()
    {
        $customers = User::find(Auth::id())->customers()->with('invoices')->paginate(10);;
        return $customers;
    }

    public function search_customers(Request $request)
    {
        $customers_ctrl = new CustomersController();
        $sum_of_invoices = $customers_ctrl->total_customers();
        $total = '';
        $status = '';

        $user = Auth::user();
        // Search by customer name or invoice number
        if ($request->has('search') && $request->search !== null) {
            $search = $request->search;
            $customers = $user->customers()->with('invoices')
                ->when($search, function ($query, $search) {
                    return $query->where('name', 'like', "%{$search}%")
                        ->orWhere('phone', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%")
                        ->orWhereHas('invoices', function ($q) use ($search) {
                            $q->where('invoice_number', 'like', "%{$search}%");
                        });
                })->orderBy('created_at', 'desc')->paginate(10);

        }else{
            return response()->json([
                'success' => true,
                'customers' => $this->get_customers(),
                'sum_of_invoices' => $sum_of_invoices,
                'total' => $total,
                'status' => $status
            ]);
        }

        return response()->json([
        'success' => true,
        'customers' => $customers,
        'sum_of_invoices' => $sum_of_invoices,
        'total' => $total,
        'status' => $status
    ]);
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
        return $invoice_ctrl->find_invoice($id);

    }

}
