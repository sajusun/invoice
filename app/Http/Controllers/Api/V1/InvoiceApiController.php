<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\CreateInvoiceRequest;
use App\Http\Resources\Api\V1\InvoiceResource;
use App\Models\Invoice;
use App\Services\InvoiceService;
use App\Services\WebhookDispatcherService;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Pagination\CursorPaginator;

class InvoiceApiController extends Controller
{
    public function __construct(
        protected WebhookDispatcherService $webhookDispatcher
    ) {}

    /**
     * List user invoices with filters and dynamic cursor pagination.
     */
    public function index(Request $request): JsonResponse
    {
        $user = $request->user();

        $query = $user->invoices()->with(['customer']);

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
                         ->orWhere('company_name', 'like', "%{$search}%")
                         ->orWhere('email', 'like', "%{$search}%")
                         ->orWhere('phone', 'like', "%{$search}%");
                  });
            });
        }

        // Filter by custom metadata (e.g. ?metadata[order_id]=1234)
        if ($request->has('metadata') && is_array($request->metadata)) {
            foreach ($request->metadata as $key => $value) {
                $query->where("metadata->{$key}", $value);
            }
        }

        $perPage = min(100, max(5, (int) $request->get('per_page', 15)));
        $invoices = $query->latest('invoice_date')->smartPaginate($perPage);

        // Build dynamic pagination metadata
        if ($invoices instanceof CursorPaginator) {
            $meta = [
                'per_page'    => $invoices->perPage(),
                'next_cursor' => $invoices->nextCursor()?->encode(),
                'prev_cursor' => $invoices->previousCursor()?->encode(),
                'has_more'    => $invoices->hasMorePages(),
                'pagination'  => 'cursor',
            ];
        } else {
            $meta = [
                'current_page' => $invoices->currentPage(),
                'per_page'     => $invoices->perPage(),
                'total'        => $invoices->total(),
                'last_page'    => $invoices->lastPage(),
                'pagination'   => 'offset',
            ];
        }

        return response()->json([
            'success' => true,
            'data'    => InvoiceResource::collection($invoices),
            'meta'    => $meta,
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

        try {
            $invoice = InvoiceService::createInvoice($user, $validated);

            return response()->json([
                'success' => true,
                'message' => 'Invoice created successfully.',
                'data'    => new InvoiceResource($invoice->load('customer')),
            ], 201);
        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'error'   => 'Creation Failed',
                'message' => $e->getMessage(),
            ], 422);
        }
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
                $q->where('id', $id)
                  ->orWhere('invoice_number', $id)
                  ->orWhere('uuid', $id)
                  ->orWhere('public_hash', $id);
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
                $q->where('id', $id)
                  ->orWhere('invoice_number', $id)
                  ->orWhere('uuid', $id)
                  ->orWhere('public_hash', $id);
            })
            ->first();

        if (!$invoice) {
            return response()->json([
                'success' => false,
                'error'   => 'Not Found',
                'message' => "Invoice '{$id}' not found.",
            ], 404);
        }

        $paidAmount = $request->has('paid_amount') ? (float) $request->paid_amount : null;
        InvoiceService::markPaid($invoice, $paidAmount);

        return response()->json([
            'success' => true,
            'message' => 'Invoice marked as paid successfully.',
            'data'    => new InvoiceResource($invoice->load('customer')),
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
                $q->where('id', $id)
                  ->orWhere('invoice_number', $id)
                  ->orWhere('uuid', $id);
            })
            ->first();

        if (!$invoice) {
            return response()->json([
                'success' => false,
                'error'   => 'Not Found',
                'message' => "Invoice '{$id}' not found.",
            ], 404);
        }

        $invoiceNumber = $invoice->invoice_number;
        $invoice->delete();

        // Dispatch Webhook
        try {
            $this->webhookDispatcher->dispatch($user, 'invoice.deleted', [
                'invoice_number' => $invoiceNumber,
            ]);
        } catch (\Throwable) {
        }

        return response()->json([
            'success' => true,
            'message' => "Invoice '{$invoiceNumber}' deleted successfully.",
        ]);
    }

    /**
     * Stream / Download Invoice PDF via API.
     */
    public function pdf(Request $request, $id)
    {
        $user = $request->user();

        $invoice = $user->invoices()
            ->with(['customer', 'user.settings'])
            ->where(function ($q) use ($id) {
                $q->where('id', $id)
                  ->orWhere('invoice_number', $id)
                  ->orWhere('uuid', $id);
            })
            ->first();

        if (!$invoice) {
            return response()->json([
                'success' => false,
                'error'   => 'Not Found',
                'message' => "Invoice '{$id}' not found.",
            ], 404);
        }

        $pdf = InvoiceService::generatePdf($invoice);

        return $pdf->stream("invoice-{$invoice->invoice_number}.pdf");
    }
}
