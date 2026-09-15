<?php

namespace App\Http\Controllers;

use App\Models\Customers;
use App\Models\Invoices;
use App\Models\User;
use App\Services\InvoiceService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth']);
    }

    /**
     * Display Modern SaaS User Dashboard.
     */
    public function dashboard(): View
    {
        $user = Auth::user();
        $user->load(['settings', 'plan']);

        $currency = $user->settings?->default_currency ?? 'USD';

        // 1. Core Financial Metrics
        $invoicesQuery = $user->invoices();

        $totalInvoicesCount = (clone $invoicesQuery)->count();
        $totalBilled        = (float) (clone $invoicesQuery)->where('status', '!=', 'cancelled')->sum('total_amount');
        $totalPaid          = (float) (clone $invoicesQuery)->where('status', '!=', 'cancelled')->sum('paid_amount');
        $totalDue           = max(0, round($totalBilled - $totalPaid, 2));

        $paidCount          = (clone $invoicesQuery)->where('status', 'paid')->count();
        $unpaidCount        = (clone $invoicesQuery)->where('status', 'unpaid')->count();
        $overdueCount       = (clone $invoicesQuery)->where('status', 'overdue')->count();
        $overdueAmount      = (float) (clone $invoicesQuery)->where('status', 'overdue')->sum('total_amount');
        $canceledCount      = (clone $invoicesQuery)->whereIn('status', ['canceled', 'cancelled'])->count();

        $totalClientsCount  = $user->customers()->count();

        // 2. 6-Month Monthly Trend for Chart.js
        $chartMonths = [];
        $chartInvoiced = [];
        $chartPaid = [];

        for ($i = 5; $i >= 0; $i--) {
            $monthDate = Carbon::now()->subMonths($i);
            $monthKey = $monthDate->format('M Y');
            $year = $monthDate->year;
            $month = $monthDate->month;

            $chartMonths[] = $monthKey;

            $monthInvoiced = (clone $invoicesQuery)
                ->whereYear('invoice_date', $year)
                ->whereMonth('invoice_date', $month)
                ->where('status', '!=', 'cancelled')
                ->sum('total_amount');

            $monthPaid = (clone $invoicesQuery)
                ->whereYear('invoice_date', $year)
                ->whereMonth('invoice_date', $month)
                ->where('status', '!=', 'cancelled')
                ->sum('paid_amount');

            $chartInvoiced[] = (float) $monthInvoiced;
            $chartPaid[]     = (float) $monthPaid;
        }

        // 3. Recent 6 Invoices
        $recentInvoices = $user->invoices()
            ->with(['customer:id,name,email,phone,address'])
            ->latest('invoice_date')
            ->take(6)
            ->get();

        // 4. Top 5 Clients by Revenue
        $topClients = $user->customers()
            ->withCount('invoices')
            ->withSum(['invoices as total_billed' => function ($q) {
                $q->where('status', '!=', 'cancelled');
            }], 'total_amount')
            ->withSum(['invoices as total_paid' => function ($q) {
                $q->where('status', '!=', 'cancelled');
            }], 'paid_amount')
            ->orderByDesc('total_billed')
            ->take(5)
            ->get();

        // 5. Active API Key for quick developer widget
        $activeApiKey = $user->apiKeys()->where('is_active', true)->latest()->first();

        // 6. Plan Quota Limits
        $plan = $user->plan;
        $maxInvoices = $plan?->max_invoices;
        $maxCustomers = $plan?->max_customers;

        return view('dashboard2', compact(
            'user',
            'currency',
            'totalInvoicesCount',
            'totalBilled',
            'totalPaid',
            'totalDue',
            'paidCount',
            'unpaidCount',
            'overdueCount',
            'overdueAmount',
            'canceledCount',
            'totalClientsCount',
            'chartMonths',
            'chartInvoiced',
            'chartPaid',
            'recentInvoices',
            'topClients',
            'activeApiKey',
            'plan',
            'maxInvoices',
            'maxCustomers'
        ));
    }

    public function customers(): View
    {
        $customer_ctrl = new CustomersController();
        $customers = $customer_ctrl->customers();
        return view('pages.customers.customers_list', ['customers' => $customers, 'controller' => $customer_ctrl]);
    }

    public function get_customers($paginate)
    {
        $customers = User::find(Auth::id())->customers()->with('invoices')->paginate($paginate);
        return $customers;
    }

    public function search_customers(Request $request)
    {
        $customers_ctrl = new CustomersController();
        $user = Auth::user();

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
        } else {
            return response()->json([
                'success'   => true,
                'customers' => $this->get_customers($request->paginate),
                'status'    => $customers_ctrl->customerStats(),
            ]);
        }

        return response()->json([
            'success'   => true,
            'customers' => $customers,
            'status'    => $customers_ctrl->customerStats(),
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

    public function my_plan()
    {
        $subscription = new SubscriptionController();
        $plans = $subscription->plans();
        $user = auth()->user();
        $payments = \App\Models\Payment::where('user_id', Auth::id())->orderBy('created_at', 'desc')->get();
        return view('subscription-plan.my-plan', compact('payments', 'plans', 'user'));
    }
}
