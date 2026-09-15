<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\SubscriptionController;
use App\Models\Invoices;
use App\Models\Payment;
use App\Models\Plan;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Admin SaaS Dashboard Overview.
     */
    public function index(Request $request)
    {
        // 1. High-level Platform Metrics
        $totalUsers          = User::count();
        $verifiedUsers       = User::whereNotNull('email_verified_at')->count();
        $unverifiedUsers     = User::whereNull('email_verified_at')->count();
        $usersThisWeek       = User::whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->count();
        $usersToday          = User::whereDate('created_at', Carbon::today())->count();

        $freePlanId          = Plan::where('type', 'free')->value('id');
        $paidUsersCount      = User::whereNotNull('plan_id')->where('plan_id', '!=', $freePlanId)->count();

        $totalPlatformInvoices = Invoices::count();
        $totalPlatformRevenue  = (float) Payment::where('payment_status', 'success')->sum('amount');

        // 2. Plan Distribution
        $plans = Plan::withCount('users')->get();
        $planDistributionLabels = $plans->pluck('name')->toArray();
        $planDistributionData   = $plans->pluck('users_count')->toArray();

        // 3. User Registration Trend (last 7 days)
        $regTrendLabels = [];
        $regTrendData = [];
        for ($i = 6; $i >= 0; $i--) {
            $day = Carbon::today()->subDays($i);
            $regTrendLabels[] = $day->format('D, M d');
            $regTrendData[]   = User::whereDate('created_at', $day)->count();
        }

        // 4. Users Table (with search & status filters)
        $query = $this->filter_user_list($request);
        $usersList = $query->with(['plan', 'settings'])->withCount('invoices')->latest()->paginate(10)->withQueryString();

        // 5. Recent Platform Payments
        $recentPayments = Payment::with(['user', 'plan'])->latest()->take(5)->get();

        return view('admin.dashboard', compact(
            'totalUsers',
            'verifiedUsers',
            'unverifiedUsers',
            'usersThisWeek',
            'usersToday',
            'paidUsersCount',
            'totalPlatformInvoices',
            'totalPlatformRevenue',
            'planDistributionLabels',
            'planDistributionData',
            'regTrendLabels',
            'regTrendData',
            'usersList',
            'recentPayments',
            'plans'
        ));
    }

    public function all_user_list(Request $request)
    {
        $users = $this->filter_user_list($request)->with(['plan', 'settings'])->withCount('invoices')->latest()->paginate($request->paginate ?? 15)->withQueryString();
        return view('admin.users-list', compact('users'));
    }

    public function filter_user_list(Request $request)
    {
        $query = User::query();

        if ($request->filled('status')) {
            if ($request->status === 'verified') {
                $query->whereNotNull('email_verified_at');
            } elseif ($request->status === 'unverified') {
                $query->whereNull('email_verified_at');
            } elseif ($request->status === 'new') {
                $query->whereDate('created_at', now()->toDateString());
            } elseif ($request->status === 'paid') {
                $freePlanId = Plan::where('type', 'free')->value('id');
                $query->whereNotNull('plan_id')->where('plan_id', '!=', $freePlanId);
            }
        }

        if ($request->filled('plan_id')) {
            $query->where('plan_id', $request->plan_id);
        }

        // Search by name, id, or email
        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $query->where(function ($q) use ($searchTerm) {
                $q->where('name', 'like', "%{$searchTerm}%")
                  ->orWhere('email', 'like', "%{$searchTerm}%")
                  ->orWhere('id', $searchTerm);
            });
        }

        return $query;
    }

    public function payments()
    {
        $payments = Payment::with(['user', 'plan'])->latest()->paginate(20);
        return view('admin.payments', compact('payments'));
    }

    public function view_payment_form(Request $request)
    {
        $sub = new SubscriptionController();
        $plans = $sub->plans();
        return view('admin.make-payment-form', compact('plans'));
    }

    public function make_payments(Request $request)
    {
        $request->validate([
            'plan_id' => 'required|exists:plans,id',
            'user_id' => 'required|exists:users,id',
        ]);

        $plan = Plan::findOrFail($request->plan_id);
        $user = User::findOrFail($request->user_id);

        $payment = Payment::create([
            'user_id'        => $user->id,
            'plan_id'        => $plan->id,
            'payment_method' => 'Manually Set by Admin',
            'amount'         => $plan->price,
            'payment_status' => 'success',
        ]);

        $user->plan_id = $plan->id;
        $user->expires_at = $plan->price > 0 ? now()->addDays(365) : null;
        $user->save();

        return redirect()->route('admin.dashboard.payments')->with('success', "Plan '{$plan->name}' assigned to {$user->name} successfully.");
    }

    public function destroy($id)
    {
        User::findOrFail($id)->delete();
        return back()->with('success', 'User deleted successfully.');
    }

    public function bulkDelete(Request $request)
    {
        $ids = json_decode($request->ids);
        if (!$ids || !is_array($ids) || count($ids) == 0) {
            return back()->with('error', 'No users selected.');
        }

        User::whereIn('id', $ids)->delete();
        return back()->with('success', 'Selected users deleted.');
    }

    public function userPage($id)
    {
        $user = User::findOrFail($id);
        $user->load(['customers', 'payments.plan', 'plan', 'settings', 'apiKeys', 'detail']);
        $user->loadCount('invoices');

        return view('admin.user-info', compact('user'));
    }
}
