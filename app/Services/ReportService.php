<?php

namespace App\Services;

use App\Models\Invoice;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class ReportService
{
    /**
     * Resolve start and end dates from filter string or custom inputs.
     */
    public static function resolveDateRange(array $filters): array
    {
        $preset = $filters['range'] ?? 'this_month';
        $now = Carbon::now();

        switch ($preset) {
            case 'today':
                $start = $now->copy()->startOfDay();
                $end = $now->copy()->endOfDay();
                $label = 'Today (' . $start->format('M d, Y') . ')';
                break;

            case 'last_month':
                $start = $now->copy()->subMonth()->startOfMonth();
                $end = $now->copy()->subMonth()->endOfMonth();
                $label = 'Last Month (' . $start->format('M Y') . ')';
                break;

            case 'this_quarter':
                $start = $now->copy()->startOfQuarter();
                $end = $now->copy()->endOfQuarter();
                $label = 'This Quarter (' . $start->format('M Y') . ' - ' . $end->format('M Y') . ')';
                break;

            case 'this_year':
                $start = $now->copy()->startOfYear();
                $end = $now->copy()->endOfYear();
                $label = 'This Year (' . $now->year . ')';
                break;

            case 'last_year':
                $start = $now->copy()->subYear()->startOfYear();
                $end = $now->copy()->subYear()->endOfYear();
                $label = 'Last Year (' . ($now->year - 1) . ')';
                break;

            case 'custom':
                $start = !empty($filters['from_date']) ? Carbon::parse($filters['from_date'])->startOfDay() : $now->copy()->startOfMonth();
                $end = !empty($filters['to_date']) ? Carbon::parse($filters['to_date'])->endOfDay() : $now->copy()->endOfDay();
                $label = $start->format('M d, Y') . ' - ' . $end->format('M d, Y');
                break;

            case 'all_time':
                $start = Carbon::createFromTimestamp(0);
                $end = $now->copy()->endOfDay();
                $label = 'All Time';
                break;

            case 'this_month':
            default:
                $start = $now->copy()->startOfMonth();
                $end = $now->copy()->endOfMonth();
                $label = 'This Month (' . $start->format('M Y') . ')';
                $preset = 'this_month';
                break;
        }

        return [
            'start'  => $start,
            'end'    => $end,
            'preset' => $preset,
            'label'  => $label,
        ];
    }

    /**
     * Get primary financial summary metrics for the given user and date range.
     */
    public static function getFinancialSummary(User $user, array $filters): array
    {
        $dateRange = self::resolveDateRange($filters);
        $query = $user->invoices()
            ->whereBetween('invoice_date', [$dateRange['start']->toDateString(), $dateRange['end']->toDateString()]);

        if (!empty($filters['customer_id'])) {
            $query->where('customer_id', $filters['customer_id']);
        }

        if (!empty($filters['status']) && $filters['status'] !== 'all') {
            $query->where('status', $filters['status']);
        }

        $allInvoices = (clone $query)->get();

        $totalInvoicesCount = $allInvoices->count();
        $totalBilled = (float) $allInvoices->where('status', '!=', 'cancelled')->sum('total_amount');
        $totalPaid = (float) $allInvoices->where('status', '!=', 'cancelled')->sum('paid_amount');
        $totalDue = max(0, round($totalBilled - $totalPaid, 2));

        $totalTax = (float) $allInvoices->where('status', '!=', 'cancelled')->sum('tax_amount');
        $totalDiscount = (float) $allInvoices->where('status', '!=', 'cancelled')->sum('discount_amount');
        $subtotalAmount = (float) $allInvoices->where('status', '!=', 'cancelled')->sum('subtotal');

        $paidCount = $allInvoices->where('status', 'paid')->count();
        $unpaidCount = $allInvoices->whereIn('status', ['unpaid', 'pending'])->count();
        $partiallyPaidCount = $allInvoices->where('status', 'partially_paid')->count();
        $overdueCount = $allInvoices->where('status', 'overdue')->count();
        $canceledCount = $allInvoices->whereIn('status', ['canceled', 'cancelled'])->count();

        $collectionRate = $totalBilled > 0 ? round(($totalPaid / $totalBilled) * 100, 1) : 0;
        $avgInvoiceValue = $totalInvoicesCount > 0 ? round($totalBilled / max(1, $totalInvoicesCount - $canceledCount), 2) : 0;

        return [
            'date_range'           => $dateRange,
            'total_invoices_count' => $totalInvoicesCount,
            'total_billed'         => $totalBilled,
            'total_paid'           => $totalPaid,
            'total_due'            => $totalDue,
            'total_tax'            => $totalTax,
            'total_discount'       => $totalDiscount,
            'subtotal_amount'      => $subtotalAmount,
            'paid_count'           => $paidCount,
            'unpaid_count'         => $unpaidCount,
            'partially_paid_count' => $partiallyPaidCount,
            'overdue_count'        => $overdueCount,
            'canceled_count'       => $canceledCount,
            'collection_rate'      => $collectionRate,
            'avg_invoice_value'    => $avgInvoiceValue,
        ];
    }

    /**
     * Get trend timelines for Chart.js (Monthly timeline over 6 or 12 months).
     */
    public static function getTimelineTrend(User $user, int $months = 6): array
    {
        $chartLabels = [];
        $chartBilled = [];
        $chartPaid = [];
        $chartDue = [];

        for ($i = $months - 1; $i >= 0; $i--) {
            $monthDate = Carbon::now()->subMonths($i);
            $monthKey = $monthDate->format('M Y');
            $year = $monthDate->year;
            $month = $monthDate->month;

            $chartLabels[] = $monthKey;

            $monthInvoiced = (float) $user->invoices()
                ->whereYear('invoice_date', $year)
                ->whereMonth('invoice_date', $month)
                ->where('status', '!=', 'cancelled')
                ->sum('total_amount');

            $monthPaid = (float) $user->invoices()
                ->whereYear('invoice_date', $year)
                ->whereMonth('invoice_date', $month)
                ->where('status', '!=', 'cancelled')
                ->sum('paid_amount');

            $chartBilled[] = round($monthInvoiced, 2);
            $chartPaid[]   = round($monthPaid, 2);
            $chartDue[]    = max(0, round($monthInvoiced - $monthPaid, 2));
        }

        return [
            'labels' => $chartLabels,
            'billed' => $chartBilled,
            'paid'   => $chartPaid,
            'due'    => $chartDue,
        ];
    }

    /**
     * Get Client Performance Leaderboard for the selected period.
     */
    public static function getClientPerformance(User $user, array $filters, int $limit = 10): Collection
    {
        $dateRange = self::resolveDateRange($filters);

        return $user->customers()
            ->withCount(['invoices' => function ($q) use ($dateRange) {
                $q->whereBetween('invoice_date', [$dateRange['start']->toDateString(), $dateRange['end']->toDateString()]);
            }])
            ->withSum(['invoices as total_billed' => function ($q) use ($dateRange) {
                $q->whereBetween('invoice_date', [$dateRange['start']->toDateString(), $dateRange['end']->toDateString()])
                  ->where('status', '!=', 'cancelled');
            }], 'total_amount')
            ->withSum(['invoices as total_paid' => function ($q) use ($dateRange) {
                $q->whereBetween('invoice_date', [$dateRange['start']->toDateString(), $dateRange['end']->toDateString()])
                  ->where('status', '!=', 'cancelled');
            }], 'paid_amount')
            ->having('total_billed', '>', 0)
            ->orderByDesc('total_billed')
            ->take($limit)
            ->get()
            ->map(function ($client) {
                $billed = (float) ($client->total_billed ?? 0);
                $paid = (float) ($client->total_paid ?? 0);
                $client->total_due = max(0, round($billed - $paid, 2));
                $client->collection_rate = $billed > 0 ? round(($paid / $billed) * 100, 1) : 0;
                return $client;
            });
    }

    /**
     * Get Invoice Aging Breakdown (Current, 1-30 days overdue, 31-60 days, 60+ days).
     */
    public static function getAgingReport(User $user): array
    {
        $today = Carbon::today();

        $unpaidInvoices = $user->invoices()
            ->whereIn('status', ['unpaid', 'pending', 'partially_paid', 'overdue'])
            ->get();

        $currentAmount = 0;
        $days1to30Amount = 0;
        $days31to60Amount = 0;
        $days60PlusAmount = 0;

        foreach ($unpaidInvoices as $inv) {
            $dueAmount = max(0, (float) $inv->total_amount - (float) $inv->paid_amount);
            $dueDate = $inv->due_date ? Carbon::parse($inv->due_date) : Carbon::parse($inv->invoice_date);

            if ($dueDate->gte($today)) {
                $currentAmount += $dueAmount;
            } else {
                $daysOverdue = $dueDate->diffInDays($today);
                if ($daysOverdue <= 30) {
                    $days1to30Amount += $dueAmount;
                } elseif ($daysOverdue <= 60) {
                    $days31to60Amount += $dueAmount;
                } else {
                    $days60PlusAmount += $dueAmount;
                }
            }
        }

        $totalAging = $currentAmount + $days1to30Amount + $days31to60Amount + $days60PlusAmount;

        return [
            'current'            => round($currentAmount, 2),
            'days_1_30'          => round($days1to30Amount, 2),
            'days_31_60'         => round($days31to60Amount, 2),
            'days_60_plus'       => round($days60PlusAmount, 2),
            'total'              => round($totalAging, 2),
            'current_percent'    => $totalAging > 0 ? round(($currentAmount / $totalAging) * 100) : 0,
            'days_1_30_percent'  => $totalAging > 0 ? round(($days1to30Amount / $totalAging) * 100) : 0,
            'days_31_60_percent' => $totalAging > 0 ? round(($days31to60Amount / $totalAging) * 100) : 0,
            'days_60_percent'    => $totalAging > 0 ? round(($days60PlusAmount / $totalAging) * 100) : 0,
        ];
    }

    /**
     * Fetch filtered invoices for table and exports.
     */
    public static function getFilteredInvoices(User $user, array $filters)
    {
        $dateRange = self::resolveDateRange($filters);
        $query = $user->invoices()
            ->with('customer')
            ->whereBetween('invoice_date', [$dateRange['start']->toDateString(), $dateRange['end']->toDateString()]);

        if (!empty($filters['customer_id'])) {
            $query->where('customer_id', $filters['customer_id']);
        }

        if (!empty($filters['status']) && $filters['status'] !== 'all') {
            $query->where('status', $filters['status']);
        }

        return $query->latest('invoice_date')->get();
    }
}
