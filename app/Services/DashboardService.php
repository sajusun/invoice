<?php

namespace App\Services;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardService
{
    /**
     * Get aggregated metrics for a user's dashboard.
     */
    public static function getMetrics(User $user): array
    {
        $user->loadMissing(['settings', 'plan']);
        $currency = $user->settings?->default_currency ?? 'USD';

        $invoicesQuery = $user->invoices();

        $totalInvoicesCount = (clone $invoicesQuery)->count();
        $totalBilled        = (float) (clone $invoicesQuery)->where('status', '!=', 'cancelled')->sum('total_amount');
        $totalPaid          = (float) (clone $invoicesQuery)->where('status', '!=', 'cancelled')->sum('paid_amount');
        $totalDue           = max(0, round($totalBilled - $totalPaid, 2));

        $paidCount          = (clone $invoicesQuery)->where('status', 'paid')->count();
        $unpaidCount        = (clone $invoicesQuery)->whereIn('status', ['unpaid', 'pending', 'partially_paid'])->count();
        $overdueCount       = (clone $invoicesQuery)->where('status', 'overdue')->count();
        $overdueAmount      = (float) (clone $invoicesQuery)->where('status', 'overdue')->sum('total_amount');
        $canceledCount      = (clone $invoicesQuery)->whereIn('status', ['canceled', 'cancelled'])->count();

        $totalClientsCount  = $user->customers()->count();

        // 6-Month Trend for Chart.js
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

        // Recent 6 Invoices
        $recentInvoices = $user->invoices()
            ->with(['customer'])
            ->latest('invoice_date')
            ->take(6)
            ->get();

        // Top 5 Clients by Revenue
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

        // Active API key for quick developer widget
        $activeApiKey = $user->apiKeys()->where('is_active', true)->latest()->first();

        // Plan limits
        $plan = $user->plan;
        $maxInvoices = $plan?->max_invoices;
        $maxCustomers = $plan?->max_customers;

        return compact(
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
        );
    }
}
