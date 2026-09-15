<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\CreateInvoiceRequest;
use App\Http\Resources\Api\V1\InvoiceResource;
use App\Models\Customers;
use App\Models\Invoices;
use App\Services\WebhookDispatcherService;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InvoiceApiController extends Controller
{
    public function __construct(
        protected WebhookDispatcherService $webhookDispatcher
    ) {}

    /**
     * List user invoices with filters and pagination.
     */
    public function index(Request $request): JsonResponse
    {
        $user = $request->user();

        $query = $user->invoices()->with(['customer:id,name,email,phone,address']);

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by customer_id
        if ($request->filled('customer_id')) {
            $query->where('customer_id', $request->customer_id);
        }

        // Filter by search query (invoice number or customer details)
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('invoice_number', 'like', "%{$search}%")
                  ->orWhereHas('customer', function ($cq) use ($search) {
                      $cq->where('name', 'like', "%{$search}%")
                         ->orWhere('email', 'like', "%{$search}%")
                         ->orWhere('phone', 'like', "%{$search}%");
                  });
            });
        }

        $perPage = min(100, max(5, (int) $request->get('per_page', 15)));
        $invoices = $query->latest('invoice_date')->paginate($perPage);

        return response()->json([
            'success' => true,
            'data'    => InvoiceResource::collection($invoices),
            'meta'    => [
                'current_page' => $invoices->currentPage(),
                'per_page'     => $invoices->perPage(),
                'total'        => $invoices->total(),
                'last_page'    => $invoices->lastPage(),
            ],
        ]);
    }

    /**
     * Create a new invoice via API.
     */
    public function store(CreateInvoiceRequest $request): JsonResponse
    {
        $user = $request->user();
        $validated = $request->validated();

        // 1. Check user plan quota limits
        $plan = $user->plan;
        if ($plan && $plan->max_invoices !== null) {
            $currentCount = $user->invoices()->count();
            if ($currentCount >= $plan->max_invoices) {
                return response()->json([
                    'success' => false,
                    'error'   => 'Quota Exceeded',
                    'message' => "You have reached your plan limit of {$plan->max_invoices} invoices. Please upgrade your plan.",
                ], 403);
            }
        }

        return DB::transaction(function () use ($user, $validated) {
            // 2. Resolve Customer (either existing customer_id or create/find by phone/email)
            if (!empty($validated['customer_id'])) {
                $customer = $user->customers()->findOrFail($validated['customer_id']);
            } else {
                $custData = $validated['customer'];
                $customer = $user->customers()
                    ->where('phone', $custData['phone'])
                    ->first();

                if (!$customer) {
                    $customer = Customers::create([
                        'user_id' => $user->id,
                        'name'    => $custData['name'],
                        'phone'   => $custData['phone'],
                        'email'   => $custData['email'] ?? null,
                        'address' => $custData['address'] ?? null,
                    ]);
                }
            }

            // 3. Process line items and compute subtotal
            $items = [];
            $subTotal = 0;
            foreach ($validated['items'] as $item) {
                $qty = (float) $item['qty'];
                $rate = (float) $item['rate'];
                $lineTotal = round($qty * $rate, 2);
                $subTotal += $lineTotal;

                $items[] = [
                    'name'  => $item['name'],
                    'qty'   => $qty,
                    'rate'  => $rate,
                    'total' => $lineTotal,
                ];
            }

            // 4. Calculate Tax & Totals
            $needTax = $validated['need_tax'] ?? (!empty($validated['tax_rate']) || !empty($validated['tax_amount']));
            if (!empty($validated['tax_amount'])) {
                $taxAmount = (float) $validated['tax_amount'];
            } elseif (!empty($validated['tax_rate'])) {
                $taxAmount = round($subTotal * ($validated['tax_rate'] / 100), 2);
            } else {
                $taxAmount = 0.00;
            }

            $totalAmount = round($subTotal + $taxAmount, 2);

            $status = strtolower($validated['status'] ?? 'unpaid');
            $paidAmount = isset($validated['paid_amount']) ? (float) $validated['paid_amount'] : ($status === 'paid' ? $totalAmount : 0.00);

            // 5. Generate Invoice Number if omitted
            $invoiceNumber = $validated['invoice_number'] ?? null;
            if (!$invoiceNumber) {
                $prefix = $user->settings?->invoice_prefix ?? 'INV-';
                $lastInvoice = Invoices::orderByDesc('id')->first();
                $nextNum = 1001;
                if ($lastInvoice && preg_match('/(\d+)$/', $lastInvoice->invoice_number, $m)) {
                    $nextNum = ((int) $m[1]) + 1;
                }
                $invoiceNumber = $prefix . $nextNum;
                while (Invoices::where('invoice_number', $invoiceNumber)->exists()) {
                    $nextNum++;
                    $invoiceNumber = $prefix . $nextNum;
                }
            }

            $currency = $validated['currency'] ?? $user->settings?->default_currency ?? 'USD';
            $invoiceDate = $validated['invoice_date'] ?? now()->format('Y-m-d');

            // 6. Create Invoice
            $invoice = Invoices::create([
                'user_id'        => $user->id,
                'customer_id'    => $customer->id,
                'invoice_number' => $invoiceNumber,
                'invoice_date'   => $invoiceDate,
                'items'          => $items,
                'notes'          => $validated['notes'] ?? null,
                'tax_amount'     => $taxAmount,
                'paid_amount'    => $paidAmount,
                'total_amount'   => $totalAmount,
                'status'         => $status,
                'need_tax'       => $needTax,
                'currency'       => $currency,
            ]);

            $invoice->setRelation('customer', $customer);

            // 7. Dispatch Webhook
            $this->webhookDispatcher->dispatch($user, 'invoice.created', [
                'invoice' => (new InvoiceResource($invoice))->resolve(),
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Invoice created successfully.',
                'data'    => new InvoiceResource($invoice),
            ], 201);
        });
    }

    /**
     * Retrieve single invoice details.
     */
    public function show(Request $request, $id): JsonResponse
    {
        $user = $request->user();

        $invoice = $user->invoices()
            ->with(['customer'])
            ->where(function ($q) use ($id) {
                if (is_numeric($id)) {
                    $q->where('id', $id)->orWhere('invoice_number', $id);
                } else {
                    $q->where('invoice_number', $id);
                }
            })
            ->first();

        if (!$invoice) {
            return response()->json([
                'success' => false,
                'error'   => 'Not Found',
                'message' => "Invoice '{$id}' not found.",
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data'    => new InvoiceResource($invoice),
        ]);
    }

    /**
     * Mark an invoice as paid or update status.
     */
    public function markPaid(Request $request, $id): JsonResponse
    {
        $user = $request->user();

        $invoice = $user->invoices()
            ->where(function ($q) use ($id) {
                if (is_numeric($id)) {
                    $q->where('id', $id)->orWhere('invoice_number', $id);
                } else {
                    $q->where('invoice_number', $id);
                }
            })
            ->first();

        if (!$invoice) {
            return response()->json([
                'success' => false,
                'error'   => 'Not Found',
                'message' => "Invoice '{$id}' not found.",
            ], 404);
        }

        $invoice->status = 'paid';
        $invoice->paid_amount = $invoice->total_amount;
        $invoice->save();

        // Dispatch Webhook
        $this->webhookDispatcher->dispatch($user, 'invoice.paid', [
            'invoice' => (new InvoiceResource($invoice))->resolve(),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Invoice marked as paid.',
            'data'    => new InvoiceResource($invoice),
        ]);
    }

    /**
     * Delete an invoice.
     */
    public function destroy(Request $request, $id): JsonResponse
    {
        $user = $request->user();

        $invoice = $user->invoices()
            ->where(function ($q) use ($id) {
                if (is_numeric($id)) {
                    $q->where('id', $id)->orWhere('invoice_number', $id);
                } else {
                    $q->where('invoice_number', $id);
                }
            })
            ->first();

        if (!$invoice) {
            return response()->json([
                'success' => false,
                'error'   => 'Not Found',
                'message' => "Invoice '{$id}' not found.",
            ], 404);
        }

        $invoice->delete();

        return response()->json([
            'success' => true,
            'message' => 'Invoice deleted successfully.',
        ]);
    }

    /**
     * Download or stream PDF for an invoice.
     */
    public function pdf(Request $request, $id)
    {
        $user = $request->user();

        $invoice = $user->invoices()
            ->with(['customer'])
            ->where(function ($q) use ($id) {
                if (is_numeric($id)) {
                    $q->where('id', $id)->orWhere('invoice_number', $id);
                } else {
                    $q->where('invoice_number', $id);
                }
            })
            ->first();

        if (!$invoice) {
            return response()->json([
                'success' => false,
                'error'   => 'Not Found',
                'message' => "Invoice '{$id}' not found.",
            ], 404);
        }

        $companyData = [
            'name'    => $user->settings?->company_name ?? $user->name,
            'address' => $user->settings?->company_address ?? '',
            'phone'   => $user->settings?->company_phone ?? '',
            'email'   => $user->settings?->company_email ?? $user->email,
        ];

        $pdf = Pdf::loadView('pages.preview.preview2', [
            'invoice_data' => $invoice,
            'company_data' => $companyData,
        ]);

        return $pdf->download("invoice-{$invoice->invoice_number}.pdf");
    }
}
