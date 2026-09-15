<?php

namespace App\Http\Resources\Api\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class InvoiceResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $items = is_string($this->items) ? json_decode($this->items, true) : ($this->items ?? []);

        // Compute subtotal from items if not directly stored
        $subtotal = 0;
        if (is_array($items)) {
            foreach ($items as $item) {
                $subtotal += ($item['qty'] ?? 1) * ($item['rate'] ?? 0);
            }
        }

        return [
            'id'             => $this->id,
            'invoice_number' => $this->invoice_number,
            'invoice_date'   => $this->invoice_date,
            'status'         => $this->status,
            'currency'       => $this->currency ?? 'USD',
            'subtotal'       => round($subtotal, 2),
            'tax_amount'     => (float) $this->tax_amount,
            'need_tax'       => (bool) $this->need_tax,
            'paid_amount'    => (float) $this->paid_amount,
            'total_amount'   => (float) $this->total_amount,
            'due_amount'     => max(0, round((float) $this->total_amount - (float) $this->paid_amount, 2)),
            'notes'          => $this->notes,
            'items'          => $items,
            'customer'       => new CustomerResource($this->whenLoaded('customer') ?: $this->customer),
            'public_url'     => route('previewInvoice', $this->invoice_number),
            'pdf_url'        => url('/api/v1/invoices/' . $this->id . '/pdf'),
            'created_at'     => $this->created_at?->toIso8601String(),
            'updated_at'     => $this->updated_at?->toIso8601String(),
        ];
    }
}
