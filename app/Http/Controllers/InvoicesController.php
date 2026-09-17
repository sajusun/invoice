<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\User;
use App\Services\InvoiceService;
use App\Services\SettingService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;


class InvoicesController extends Controller
{
    public function view(): View
    {
        $invoiceId = InvoiceService::invoiceIdGenerator(Auth::user());
        $settings = Auth::check() ? SettingService::forUser(Auth::user()) : null;

        return view('pages.invoice', ['invoiceId' => $invoiceId, 'settings' => $settings]);
    }

    public function invoiceList(): View
    {
        return view('pages.invoice.invoice-list');
    }

    public function theme(): View
    {
        return view('pages.invoice.builder');
    }

    public function getInvoiceCounts(): array
    {
        $user = Auth::user();
        if (!$user) {
            return ['all' => 0, 'paid' => 0, 'unpaid' => 0, 'overdue' => 0];
        }

        $query = $user->invoices();

        return [
            'all'     => (clone $query)->count(),
            'paid'    => (clone $query)->where('status', 'paid')->count(),
            'unpaid'  => (clone $query)->whereIn('status', ['unpaid', 'pending', 'partially_paid'])->count(),
            'overdue' => (clone $query)->where('status', 'overdue')->count(),
        ];
    }

    public function previewInvoice($id = '')
    {
        $invoice = null;

        if (Auth::check()) {
            $user = Auth::user();
            $invoice = $user->invoices()
                ->with(['customer'])
                ->where(function ($q) use ($id) {
                    $q->where('invoice_number', $id)
                      ->orWhere('uuid', $id)
                      ->orWhere('public_hash', $id)
                      ->orWhere('id', $id);
                })->first();
        }

        // Check if invoice exists in guest session
        if (!$invoice && session()->has($id)) {
            $sessionData = session($id);
            return view('pages.invoice.preview2', ['invoice_data' => $sessionData]);
        }

        if (!$invoice) {
            // Also check if public hash matches any public invoice
            $invoice = Invoice::with(['customer', 'user'])
                ->where('public_hash', $id)
                ->orWhere('uuid', $id)
                ->first();
        }

        if (!$invoice) {
            return redirect()->route('invoice.builder');
        }

        $companyData = SettingService::getCompanyData($invoice->user);

        return view('pages.invoice_preview', [
            'invoice_data' => $invoice,
            'company_data' => $companyData,
        ]);
    }

    public function makeInvoice(Request $request): JsonResponse
    {
        $user = Auth::user();

        // Guest Session Flow
        if (!$user) {
            $invoiceNumber = $request->input('details.number', $request->input('invoice_number', InvoiceService::invoiceIdGenerator()));
            $calculations = InvoiceService::calculateTotals(
                $request->input('items', []),
                (float) $request->input('tax_percentage', 10)
            );

            $sessionData = [
                'invoice_number' => $invoiceNumber,
                'invoice_date'   => $request->input('details.issueDate', $request->input('invoice_date', date('Y-m-d'))),
                'items'          => $calculations['items'],
                'subtotal'       => $calculations['subtotal'],
                'tax_amount'     => $calculations['tax_amount'],
                'total_amount'   => $calculations['total_amount'],
                'paid_amount'    => 0,
                'status'         => 'unpaid',
                'customer'       => [
                    'name'    => $request->input('client.name', $request->input('name', 'Valued Client')),
                    'email'   => $request->input('client.email', $request->input('email')),
                    'phone'   => $request->input('client.phone', $request->input('phone', '0000000000')),
                    'address' => $request->input('client.address', $request->input('address', '')),
                ],
            ];

            session([$invoiceNumber => $sessionData]);

            return response()->json([
                'success'  => true,
                'message'  => 'Invoice created in session!',
                'redirect' => route('previewInvoice', $invoiceNumber),
            ]);
        }

        try {
            // Transform builder.vue nested inputs or flat inputs
            $clientData = [
                'name'    => $request->input('client.name', $request->input('name', 'Valued Client')),
                'email'   => $request->input('client.email', $request->input('email')),
                'phone'   => $request->input('client.phone', $request->input('phone', '0000000000')),
                'address' => $request->input('client.address', $request->input('address', '')),
            ];

            $invoiceData = [
                'customer'        => $clientData,
                'customer_id'     => $request->input('customer_id'),
                'invoice_number'  => $request->input('details.number', $request->input('invoice_number')),
                'invoice_date'    => $request->input('details.issueDate', $request->input('invoice_date', date('Y-m-d'))),
                'due_date'        => $request->input('details.dueDate', $request->input('due_date')),
                'items'           => $request->input('items', []),
                'tax_percentage'  => (float) $request->input('tax_percentage', $request->input('tax_rate', 0)),
                'discount_amount' => (float) $request->input('discount_amount', 0),
                'discount_type'   => $request->input('discount_type', 'fixed'),
                'paid_amount'     => (float) $request->input('paid_amount', 0),
                'currency'        => $request->input('currency', SettingService::forUser($user)->default_currency),
                'notes'           => $request->input('notes'),
                'terms'           => $request->input('terms'),
                'metadata'        => $request->input('metadata'),
            ];

            $invoice = InvoiceService::createInvoice($user, $invoiceData);

            return response()->json([
                'success'  => true,
                'message'  => 'Invoice created successfully!',
                'invoice'  => $invoice,
                'redirect' => route('previewInvoice', $invoice->invoice_number),
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to create invoice: ' . $e->getMessage(),
            ], 422);
        }
    }

    public function get_all_invoices()
    {
        return Auth::user()->invoices()
            ->with(['customer'])
            ->latest('invoice_date')
            ->get();
    }

    public function all_invoices_by_paginate(int $paginate = 15)
    {
        return InvoiceService::paginateForUser(Auth::user(), request(), $paginate);
    }

    public function search_invoice(Request $request): JsonResponse
    {
        $user = Auth::user();
        $invoices = InvoiceService::paginateForUser($user, $request, (int) $request->get('paginate', 15));

        return response()->json([
            'success'  => true,
            'status'   => $this->getInvoiceCounts(),
            'invoices' => $invoices,
            'message'  => 'Invoices retrieved successfully.',
        ]);
    }

    public function find_invoice($id): array
    {
        return Auth::user()->invoices()->where('customer_id', $id)->get()->all();
    }

    public function num_of_invoices(): int
    {
        return Auth::user()->invoices()->count();
    }

    public function get_invoice($id): JsonResponse
    {
        $invoice = Auth::user()->invoices()->with('customer')->findOrFail($id);
        return response()->json($invoice);
    }

    public function sum_of_total(): float
    {
        return (float) Auth::user()->invoices()->where('status', '!=', 'cancelled')->sum('total_amount');
    }

    public function sum_of_paid(): float
    {
        return (float) Auth::user()->invoices()->where('status', '!=', 'cancelled')->sum('paid_amount');
    }

    public function sum_of_due(): float
    {
        return max(0, round($this->sum_of_total() - $this->sum_of_paid(), 2));
    }

    public function invoice_status(string $status = 'pending'): int
    {
        return Auth::user()->invoices()->where('status', $status)->count();
    }

    public function change_status(Request $request): RedirectResponse
    {
        $user = Auth::user();
        $invoice = $user->invoices()->where('invoice_number', $request->id)->firstOrFail();

        $paymentStatus = strtolower($request->paymentStatus);

        if ($paymentStatus === 'paid') {
            InvoiceService::markPaid($invoice);
        } else {
            $invoice->status = $paymentStatus;
            $invoice->save();
        }

        return redirect()->back()->with('message', 'Invoice status updated successfully.');
    }

    public function delete_invoice($invoiceNumber): RedirectResponse
    {
        $deleted = InvoiceService::delete_invoice($invoiceNumber);

        if ($deleted) {
            return redirect()->back()->with(['message' => 'Invoice deleted successfully.', 'response' => 'success']);
        }

        return redirect()->back()->with(['message' => 'Failed to delete invoice.', 'response' => 'error']);
    }

    /**
     * Send invoice email to the customer.
     */
    public function sendEmail(Request $request, string $invoiceNumber): JsonResponse
    {
        $user    = Auth::user();
        $invoice = $user->invoices()
            ->with(['customer', 'user'])
            ->where('invoice_number', $invoiceNumber)
            ->firstOrFail();

        try {
            InvoiceService::sendEmail($invoice, (bool) $request->boolean('attach_pdf', true));

            return response()->json([
                'success' => true,
                'message' => "Invoice #{$invoiceNumber} sent to {$invoice->customer->email} successfully.",
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 422);
        }
    }

    /**
     * Show edit form for an invoice.
     */
    public function edit(string $invoiceNumber): View
    {
        $user    = Auth::user();
        $invoice = $user->invoices()
            ->with(['customer'])
            ->where('invoice_number', $invoiceNumber)
            ->firstOrFail();

        $settings  = SettingService::forUser($user);
        $customers = $user->customers()->orderBy('name')->get(['id', 'name', 'email', 'phone', 'address', 'company_name']);

        return view('pages.invoice.edit', compact('invoice', 'settings', 'customers'));
    }

    /**
     * Update an existing invoice.
     */
    public function update(Request $request, string $invoiceNumber): JsonResponse
    {
        $user    = Auth::user();
        $invoice = $user->invoices()
            ->with(['customer', 'user'])
            ->where('invoice_number', $invoiceNumber)
            ->firstOrFail();

        try {
            $updated = InvoiceService::updateInvoice($invoice, $request->all());

            return response()->json([
                'success'  => true,
                'message'  => 'Invoice updated successfully.',
                'invoice'  => $updated,
                'redirect' => route('previewInvoice', $updated->invoice_number),
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update invoice: ' . $e->getMessage(),
            ], 422);
        }
    }

    /**
     * Duplicate (clone) an invoice.
     */
    public function duplicate(string $invoiceNumber): JsonResponse
    {
        $user    = Auth::user();
        $source  = $user->invoices()
            ->with(['customer', 'user'])
            ->where('invoice_number', $invoiceNumber)
            ->firstOrFail();

        try {
            $newInvoice = InvoiceService::duplicateInvoice($source);

            return response()->json([
                'success'  => true,
                'message'  => "Invoice duplicated as #{$newInvoice->invoice_number}.",
                'invoice'  => $newInvoice,
                'redirect' => route('previewInvoice', $newInvoice->invoice_number),
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to duplicate invoice: ' . $e->getMessage(),
            ], 422);
        }
    }

    /**
     * Bulk action on multiple invoices (delete or status change).
     */
    public function bulkAction(Request $request): JsonResponse
    {
        $user    = Auth::user();
        $action  = $request->input('action'); // 'delete' | 'status'
        $numbers = (array) $request->input('invoice_numbers', []);
        $status  = $request->input('status');

        if (empty($numbers)) {
            return response()->json(['success' => false, 'message' => 'No invoices selected.'], 422);
        }

        $query = $user->invoices()->whereIn('invoice_number', $numbers);

        if ($action === 'delete') {
            $count = $query->count();
            $query->delete();
            return response()->json(['success' => true, 'message' => "{$count} invoice(s) deleted."]);
        }

        if ($action === 'status' && $status) {
            $count = $query->update(['status' => strtolower($status)]);
            return response()->json(['success' => true, 'message' => "{$count} invoice(s) updated to '{$status}'."]);
        }

        return response()->json(['success' => false, 'message' => 'Invalid action.'], 422);
    }
}
