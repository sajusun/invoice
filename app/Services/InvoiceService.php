<?php

namespace App\Services;

use App\Helpers\AdminNotifier;
use App\Mail\InvoiceMail;
use App\Models\Customer;
use App\Models\Invoice;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Exception;
use Illuminate\Contracts\Pagination\CursorPaginator;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class InvoiceService
{
    /**
     * Generate standard unique invoice number.
     */
    public static function invoiceIdGenerator(?User $user = null): string
    {
        $settings = SettingService::forUser($user);
        $prefix = $settings->invoice_prefix ?: 'INV-';

        $year = date('Y');
        $randomNumber = str_pad((string) mt_rand(1, 99999), 5, '0', STR_PAD_LEFT);

        return "{$prefix}{$year}-{$randomNumber}";
    }

    /**
     * Calculate line items totals, tax, and discount.
     */
    public static function calculateTotals(
        array $rawItems,
        float $taxPercentage = 0,
        float $discountAmount = 0,
        string $discountType = 'fixed'
    ): array {
        $items = [];
        $subtotal = 0;

        foreach ($rawItems as $item) {
            $name = $item['name'] ?? $item['description'] ?? 'Item';
            $desc = $item['description'] ?? $name;
            $qty  = max(0.01, (float) ($item['qty'] ?? $item['quantity'] ?? 1));
            $rate = max(0, (float) ($item['rate'] ?? $item['unit_price'] ?? 0));
            $lineTotal = round($qty * $rate, 2);
            $subtotal += $lineTotal;

            $items[] = [
                'name'        => $name,
                'description' => $desc,
                'qty'         => $qty,
                'rate'        => $rate,
                'total'       => $lineTotal,
            ];
        }

        if (empty($items)) {
            $items[] = [
                'name'        => 'General Service',
                'description' => 'General Service',
                'qty'         => 1,
                'rate'        => 0,
                'total'       => 0,
            ];
        }

        // Calculate Discount
        $actualDiscount = 0;
        if ($discountAmount > 0) {
            if ($discountType === 'percentage') {
                $actualDiscount = round($subtotal * ($discountAmount / 100), 2);
            } else {
                $actualDiscount = round(min($subtotal, $discountAmount), 2);
            }
        }

        $taxableAmount = max(0, $subtotal - $actualDiscount);

        // Calculate Tax
        $taxAmount = 0;
        if ($taxPercentage > 0) {
            $taxAmount = round($taxableAmount * ($taxPercentage / 100), 2);
        }

        $totalAmount = round($taxableAmount + $taxAmount, 2);

        return [
            'items'           => $items,
            'subtotal'        => round($subtotal, 2),
            'discount_amount' => $actualDiscount,
            'discount_type'   => $discountType,
            'tax_amount'      => $taxAmount,
            'tax_percentage'  => $taxPercentage,
            'total_amount'    => $totalAmount,
        ];
    }

    /**
     * Create invoice with customer resolution, calculations, and webhooks.
     */
    public static function createInvoice(User $user, array $data): Invoice
    {
        return DB::transaction(function () use ($user, $data) {
            // 1. Resolve Customer
            $customer = null;
            if (!empty($data['customer_id'])) {
                $customer = $user->customers()->findOrFail($data['customer_id']);
            } elseif (!empty($data['customer'])) {
                $customer = CustomerService::findOrCreate($user, $data['customer']);
            } else {
                $customer = CustomerService::findOrCreate($user, [
                    'name'    => $data['client_name'] ?? $data['name'] ?? 'Valued Client',
                    'email'   => $data['client_email'] ?? $data['email'] ?? null,
                    'phone'   => $data['client_phone'] ?? $data['phone'] ?? '0000000000',
                    'address' => $data['client_address'] ?? $data['address'] ?? null,
                ]);
            }

            // 2. Calculate Totals
            $calculations = static::calculateTotals(
                $data['items'] ?? [],
                (float) ($data['tax_percentage'] ?? $data['tax_rate'] ?? 0),
                (float) ($data['discount_amount'] ?? 0),
                $data['discount_type'] ?? 'fixed'
            );

            $paidAmount = (float) ($data['paid_amount'] ?? 0);
            $totalAmount = $calculations['total_amount'];

            // Status determination
            $status = $data['status'] ?? null;
            if (!$status) {
                if ($paidAmount >= $totalAmount && $totalAmount > 0) {
                    $status = 'paid';
                } elseif ($paidAmount > 0) {
                    $status = 'partially_paid';
                } else {
                    $status = 'unpaid';
                }
            }

            $currency = $data['currency'] ?? SettingService::forUser($user)->default_currency ?: 'USD';
            $invoiceNumber = $data['invoice_number'] ?? static::invoiceIdGenerator($user);

            // 3. Create Invoice Record
            $invoice = Invoice::create([
                'user_id'         => $user->id,
                'customer_id'     => $customer->id,
                'invoice_number'  => $invoiceNumber,
                'invoice_date'    => $data['invoice_date'] ?? date('Y-m-d'),
                'due_date'        => $data['due_date'] ?? null,
                'items'           => $calculations['items'],
                'subtotal'        => $calculations['subtotal'],
                'tax_amount'      => $calculations['tax_amount'],
                'discount_amount' => $calculations['discount_amount'],
                'discount_type'   => $calculations['discount_type'],
                'paid_amount'     => $paidAmount,
                'total_amount'    => $totalAmount,
                'currency'        => $currency,
                'status'          => $status,
                'need_tax'        => $calculations['tax_amount'] > 0,
                'notes'           => $data['notes'] ?? null,
                'terms'           => $data['terms'] ?? null,
                'metadata'        => $data['metadata'] ?? null,
            ]);

            // 4. Notifications & Webhooks (isolated in try-catch to prevent transaction failure)
            try {
                AdminNotifier::invoiceGenerate($invoice);
            } catch (\Throwable) {
            }

            try {
                app(WebhookDispatcherService::class)->dispatchForUser($user, 'invoice.created', [
                    'invoice_id'     => $invoice->id,
                    'invoice_number' => $invoice->invoice_number,
                    'total_amount'   => $invoice->total_amount,
                    'status'         => $invoice->status,
                    'metadata'       => $invoice->metadata,
                ]);
            } catch (\Throwable) {
            }

            return $invoice;
        });
    }

    /**
     * Mark an invoice as paid and dispatch webhook.
     */
    public static function markPaid(Invoice $invoice, ?float $amount = null): Invoice
    {
        $invoice->paid_amount = $amount ?? $invoice->total_amount;
        $invoice->status = 'paid';
        $invoice->save();

        try {
            app(WebhookDispatcherService::class)->dispatchForUser($invoice->user, 'invoice.paid', [
                'invoice_id'     => $invoice->id,
                'invoice_number' => $invoice->invoice_number,
                'total_amount'   => $invoice->total_amount,
                'paid_amount'    => $invoice->paid_amount,
                'status'         => 'paid',
                'metadata'       => $invoice->metadata,
            ]);
        } catch (\Throwable) {
        }

        return $invoice;
    }

    /**
     * Paginate user invoices with dynamic cursor or offset pagination.
     */
    public static function paginateForUser(
        User $user,
        ?Request $request = null,
        int $perPage = 15
    ): CursorPaginator|LengthAwarePaginator {
        $request = $request ?? request();

        $query = $user->invoices()->with('customer');

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('customer_id')) {
            $query->where('customer_id', $request->customer_id);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('invoice_number', 'like', "%{$search}%")
                    ->orWhereHas('customer', function ($cq) use ($search) {
                        $cq->where('name', 'like', "%{$search}%")
                            ->orWhere('company_name', 'like', "%{$search}%")
                            ->orWhere('email', 'like', "%{$search}%")
                            ->orWhere('phone', 'like', "%{$search}%");
                    });
            });
        }

        $perPage = min(100, max(5, (int) $request->get('per_page', $perPage)));

        return $query->latest('invoice_date')->smartPaginate($perPage);
    }

    /**
     * Find invoice by invoice_number for authenticated user.
     */
    public static function find_invoice(string $invoiceNumber): ?Invoice
    {
        $user = Auth::user();
        if (!$user) {
            return null;
        }

        return $user->invoices()
            ->with(['customer'])
            ->where('invoice_number', $invoiceNumber)
            ->first();
    }

    /**
     * Delete an invoice ensuring tenant ownership.
     */
    public static function delete_invoice(string $invoiceNumber): bool
    {
        $user = Auth::user();
        if (!$user) {
            return false;
        }

        return (bool) $user->invoices()->where('invoice_number', $invoiceNumber)->delete();
    }

    /**
     * Get default currency.
     */
    public static function currency(): string
    {
        return SettingService::forUser()->default_currency ?: 'USD';
    }

    /**
     * Generate PDF binary stream for an invoice.
     */
    public static function generatePdf(Invoice $invoice)
    {
        $invoice->loadMissing(['customer', 'user.settings']);
        $companyData = SettingService::getCompanyData($invoice->user);

        return Pdf::loadView('pages.invoice.pdf_template', [
            'invoice'     => $invoice,
            'customer'    => $invoice->customer,
            'company'     => $companyData,
            'items'       => is_array($invoice->items) ? $invoice->items : json_decode($invoice->items, true),
        ])->setPaper('a4');
    }

    /**
     * Send invoice email to the customer.
     *
     * @throws \Throwable
     */
    public static function sendEmail(Invoice $invoice, bool $attachPdf = true): void
    {
        $invoice->loadMissing(['customer', 'user']);

        $customerEmail = $invoice->customer?->email;

        if (empty($customerEmail)) {
            throw new Exception('Customer has no email address configured.');
        }

        Mail::to($customerEmail, $invoice->customer->name)
            ->send(new InvoiceMail($invoice, $attachPdf));
    }

    /**
     * Update an existing invoice with recalculated totals.
     *
     * @throws \Throwable
     */
    public static function updateInvoice(Invoice $invoice, array $data): Invoice
    {
        return DB::transaction(function () use ($invoice, $data) {
            // Resolve new customer if provided
            if (!empty($data['customer_id'])) {
                $invoice->customer_id = $data['customer_id'];
            } elseif (!empty($data['customer'])) {
                $customer = CustomerService::findOrCreate($invoice->user, $data['customer']);
                $invoice->customer_id = $customer->id;
            }

            // Recalculate totals if items provided
            if (!empty($data['items'])) {
                $calculations = static::calculateTotals(
                    $data['items'],
                    (float) ($data['tax_percentage'] ?? $data['tax_rate'] ?? 0),
                    (float) ($data['discount_amount'] ?? 0),
                    $data['discount_type'] ?? 'fixed'
                );

                $paidAmount  = (float) ($data['paid_amount'] ?? $invoice->paid_amount ?? 0);
                $totalAmount = $calculations['total_amount'];

                $status = $data['status'] ?? null;
                if (!$status) {
                    if ($paidAmount >= $totalAmount && $totalAmount > 0) {
                        $status = 'paid';
                    } elseif ($paidAmount > 0) {
                        $status = 'partially_paid';
                    } else {
                        $status = $invoice->status;
                    }
                }

                $invoice->fill([
                    'items'           => $calculations['items'],
                    'subtotal'        => $calculations['subtotal'],
                    'tax_amount'      => $calculations['tax_amount'],
                    'discount_amount' => $calculations['discount_amount'],
                    'discount_type'   => $calculations['discount_type'],
                    'total_amount'    => $totalAmount,
                    'paid_amount'     => $paidAmount,
                    'status'          => $status,
                    'need_tax'        => $calculations['tax_amount'] > 0,
                ]);
            }

            // Scalar field updates
            foreach (['invoice_date', 'due_date', 'currency', 'notes', 'terms', 'metadata', 'status'] as $field) {
                if (array_key_exists($field, $data)) {
                    $invoice->$field = $data[$field];
                }
            }

            $invoice->save();

            // Webhook
            try {
                app(WebhookDispatcherService::class)->dispatchForUser($invoice->user, 'invoice.updated', [
                    'invoice_id'     => $invoice->id,
                    'invoice_number' => $invoice->invoice_number,
                    'total_amount'   => $invoice->total_amount,
                    'status'         => $invoice->status,
                ]);
            } catch (\Throwable) {
            }

            return $invoice->load('customer');
        });
    }

    /**
     * Duplicate (clone) an invoice as a new draft with a fresh invoice number.
     */
    public static function duplicateInvoice(Invoice $source): Invoice
    {
        $source->loadMissing(['customer', 'user']);

        $newData = [
            'customer_id'     => $source->customer_id,
            'invoice_number'  => static::invoiceIdGenerator($source->user),
            'invoice_date'    => now()->format('Y-m-d'),
            'due_date'        => $source->due_date?->addDays(30)?->format('Y-m-d'),
            'items'           => $source->items,
            'subtotal'        => $source->subtotal,
            'tax_amount'      => $source->tax_amount,
            'discount_amount' => $source->discount_amount,
            'discount_type'   => $source->discount_type,
            'total_amount'    => $source->total_amount,
            'paid_amount'     => 0,
            'currency'        => $source->currency,
            'status'          => 'draft',
            'need_tax'        => $source->need_tax,
            'notes'           => $source->notes,
            'terms'           => $source->terms,
            'metadata'        => $source->metadata,
        ];

        return Invoice::create(array_merge($newData, [
            'user_id' => $source->user_id,
        ]));
    }
}
