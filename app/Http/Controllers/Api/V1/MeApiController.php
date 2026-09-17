<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\V1\UserResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class MeApiController extends Controller
{
    /**
     * Get authenticated developer user profile & limits.
     */
    public function show(Request $request): JsonResponse
    {
        $user = $request->user();
        $user->load(['plan', 'settings']);

        return response()->json([
            'success' => true,
            'data'    => new UserResource($user),
        ]);
    }

    /**
     * Get developer quota usage and analytics.
     */
    public function usage(Request $request): JsonResponse
    {
        $user = $request->user();
        $plan = $user->plan;

        $totalInvoices = $user->invoices()->count();
        $invoicesThisMonth = $user->invoices()->whereMonth('created_at', now()->month)->whereYear('created_at', now()->year)->count();
        $totalCustomers = $user->customers()->count();
        $totalRevenue = (float) $user->invoices()->where('status', 'paid')->sum('total_amount');
        $outstandingDue = (float) $user->invoices()->whereIn('status', ['unpaid', 'partially_paid', 'overdue'])->sum('total_amount');

        return response()->json([
            'success' => true,
            'data'    => [
                'plan' => [
                    'name'          => $plan?->name ?? 'Free',
                    'max_invoices'  => $plan?->max_invoices,
                    'max_customers' => $plan?->max_customers,
                ],
                'usage' => [
                    'total_invoices'      => $totalInvoices,
                    'invoices_this_month' => $invoicesThisMonth,
                    'invoices_remaining'  => $plan?->max_invoices !== null ? max(0, $plan->max_invoices - $totalInvoices) : 'unlimited',
                    'total_customers'     => $totalCustomers,
                    'customers_remaining' => $plan?->max_customers !== null ? max(0, $plan->max_customers - $totalCustomers) : 'unlimited',
                ],
                'financials' => [
                    'total_revenue'   => $totalRevenue,
                    'outstanding_due' => $outstandingDue,
                ],
            ],
        ]);
    }
}

