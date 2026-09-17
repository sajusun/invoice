<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Services\ReportService;
use App\Services\SettingService;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ReportController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'verified']);
    }

    /**
     * Main Financial & Business Reports Dashboard
     */
    public function index(Request $request): View
    {
        $user = Auth::user();
        $user->loadMissing('settings');
        $currency = $user->settings?->default_currency ?? 'USD';

        $filters = [
            'range'       => $request->query('range', 'this_month'),
            'from_date'   => $request->query('from_date'),
            'to_date'     => $request->query('to_date'),
            'customer_id' => $request->query('customer_id'),
            'status'      => $request->query('status', 'all'),
        ];

        $summary = ReportService::getFinancialSummary($user, $filters);
        $timeline = ReportService::getTimelineTrend($user, 6);
        $topClients = ReportService::getClientPerformance($user, $filters, 8);
        $aging = ReportService::getAgingReport($user);
        $invoices = ReportService::getFilteredInvoices($user, $filters);
        $allCustomers = $user->customers()->orderBy('name')->get(['id', 'name', 'company_name']);

        return view('reports.index', compact(
            'user',
            'currency',
            'filters',
            'summary',
            'timeline',
            'topClients',
            'aging',
            'invoices',
            'allCustomers'
        ));
    }

    /**
     * Export Filtered Invoices as CSV
     */
    public function exportCsv(Request $request): StreamedResponse
    {
        $user = Auth::user();
        $filters = [
            'range'       => $request->query('range', 'this_month'),
            'from_date'   => $request->query('from_date'),
            'to_date'     => $request->query('to_date'),
            'customer_id' => $request->query('customer_id'),
            'status'      => $request->query('status', 'all'),
        ];

        $invoices = ReportService::getFilteredInvoices($user, $filters);
        $dateRange = ReportService::resolveDateRange($filters);
        $fileName = 'invozen_report_' . $dateRange['preset'] . '_' . date('Y-m-d') . '.csv';

        $headers = [
            'Content-Type'        => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"{$fileName}\"",
            'Pragma'              => 'no-cache',
            'Cache-Control'       => 'must-revalidate, post-check=0, pre-check=0',
            'Expires'             => '0',
        ];

        $callback = function () use ($invoices) {
            $file = fopen('php://output', 'w');

            // Add UTF-8 BOM for proper Excel compatibility
            fprintf($file, chr(0xEF) . chr(0xBB) . chr(0xBF));

            // CSV Header row
            fputcsv($file, [
                'Invoice Number',
                'Client Name',
                'Client Email',
                'Issue Date',
                'Due Date',
                'Status',
                'Currency',
                'Subtotal',
                'Tax Amount',
                'Discount Amount',
                'Total Amount',
                'Paid Amount',
                'Balance Due',
            ]);

            foreach ($invoices as $inv) {
                $due = max(0, round((float) $inv->total_amount - (float) $inv->paid_amount, 2));
                fputcsv($file, [
                    $inv->invoice_number,
                    $inv->customer?->name ?? 'N/A',
                    $inv->customer?->email ?? 'N/A',
                    $inv->invoice_date,
                    $inv->due_date ?? 'N/A',
                    ucfirst($inv->status),
                    $inv->currency ?? 'USD',
                    number_format((float) $inv->subtotal, 2, '.', ''),
                    number_format((float) $inv->tax_amount, 2, '.', ''),
                    number_format((float) $inv->discount_amount, 2, '.', ''),
                    number_format((float) $inv->total_amount, 2, '.', ''),
                    number_format((float) $inv->paid_amount, 2, '.', ''),
                    number_format($due, 2, '.', ''),
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Download Branded Financial Statement PDF
     */
    public function exportPdf(Request $request)
    {
        $user = Auth::user();
        $user->loadMissing('settings');
        $companyData = SettingService::getCompanyData($user);

        $filters = [
            'range'       => $request->query('range', 'this_month'),
            'from_date'   => $request->query('from_date'),
            'to_date'     => $request->query('to_date'),
            'customer_id' => $request->query('customer_id'),
            'status'      => $request->query('status', 'all'),
        ];

        $summary = ReportService::getFinancialSummary($user, $filters);
        $invoices = ReportService::getFilteredInvoices($user, $filters);
        $topClients = ReportService::getClientPerformance($user, $filters, 5);
        $aging = ReportService::getAgingReport($user);
        $currency = $companyData['currency'] ?? 'USD';

        $pdf = Pdf::loadView('reports.pdf-statement', compact(
            'user',
            'companyData',
            'summary',
            'invoices',
            'topClients',
            'aging',
            'currency',
            'filters'
        ))->setPaper('a4', 'portrait');

        $fileName = 'financial_statement_' . date('Y_m_d') . '.pdf';

        return $pdf->download($fileName);
    }
}
