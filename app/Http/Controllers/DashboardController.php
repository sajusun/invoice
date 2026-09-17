<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Payment;
use App\Models\Plan;
use App\Services\CustomerService;
use App\Services\DashboardService;
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
        $this->middleware(['auth']);
    }

    /**
     * Display Modern SaaS User Dashboard.
     */
    public function dashboard(): View
    {
        $metrics = DashboardService::getMetrics(Auth::user());

        return view('dashboard', $metrics);
    }

    /**
     * Display customer list page.
     */
    public function customers(): View
    {
        $user = Auth::user();
        $customers = $user->customers()->latest()->get();

        return view('pages.customers.customers_list', compact('customers'));
    }

    /**
     * Get paginated customers for AJAX requests.
     */
    public function get_customers(int $paginate = 15)
    {
        return CustomerService::paginateForUser(Auth::user(), request(), $paginate);
    }

    /**
     * Search customers.
     */
    public function search_customers(Request $request): JsonResponse
    {
        $user = Auth::user();
        $customers = CustomerService::paginateForUser($user, $request, (int) $request->get('paginate', 15));

        $stats = [
            'total'   => $user->customers()->count(),
            'new'     => $user->customers()->where('created_at', '>=', now()->subDays(7))->count(),
            'unpaid'  => $user->customers()->whereHas('invoices', fn ($q) => $q->whereIn('status', ['pending', 'unpaid']))->count(),
            'overdue' => $user->customers()->whereHas('invoices', fn ($q) => $q->where('status', 'overdue'))->count(),
        ];

        return response()->json([
            'success'   => true,
            'customers' => $customers,
            'status'    => $stats,
        ]);
    }

    /**
     * Customer details data endpoint.
     */
    public function get_customer_data(int $id): array
    {
        $customer = Auth::user()->customers()->with('invoices')->findOrFail($id);
        $metrics = CustomerService::getCustomerMetrics($customer);

        return [
            'customer_data'    => $customer,
            'customer_pending' => $metrics['unpaid_count'],
            'customer_revenue' => $metrics['total_billed'],
        ];
    }

    /**
     * Invoices for a specific customer.
     */
    public function get_customer_invoice(int $id): array
    {
        return Auth::user()->invoices()->where('customer_id', $id)->get()->all();
    }

    /**
     * Subscription / Plan details page.
     */
    public function my_plan(): View
    {
        $user = Auth::user();

        if (!$user->plan_id) {
            $freePlan = Plan::where('type', 'free')->orWhere('monthly_price', 0)->first();
            if ($freePlan) {
                $user->plan_id = $freePlan->id;
                $user->save();
            }
        }

        $user->loadMissing(['plan', 'settings']);
        $plans = Plan::where('is_active', true)->orderBy('monthly_price', 'asc')->get();
        if ($plans->isEmpty()) {
            $plans = Plan::all();
        }

        $payments = Payment::with('plan')->where('user_id', $user->id)->latest()->get();

        $invoicesThisMonth = $user->invoices()->whereMonth('created_at', now()->month)->whereYear('created_at', now()->year)->count();
        $totalInvoicesCount = $user->invoices()->count();
        $totalClientsCount = $user->customers()->count();

        return view('subscription-plan.my-plan', compact(
            'payments',
            'plans',
            'user',
            'invoicesThisMonth',
            'totalInvoicesCount',
            'totalClientsCount'
        ));
    }
}
