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
            'id'              => $this->id,
            'uuid'            => $this->uuid,
            'public_hash'     => $this->public_hash,
            'invoice_number'  => $this->invoice_number,
            'invoice_date'    => $this->invoice_date?->format('Y-m-d') ?? $this->invoice_date,
            'due_date'        => $this->due_date?->format('Y-m-d') ?? $this->due_date,
            'status'          => $this->status,
            'currency'        => $this->currency ?? 'USD',
            'subtotal'        => (float) ($this->subtotal ?: round($subtotal, 2)),
            'tax_amount'      => (float) $this->tax_amount,
            'discount_amount' => (float) $this->discount_amount,
            'discount_type'   => $this->discount_type ?? 'fixed',
            'need_tax'        => (bool) $this->need_tax,
            'paid_amount'     => (float) $this->paid_amount,
            'total_amount'    => (float) $this->total_amount,
            'due_amount'      => max(0, round((float) $this->total_amount - (float) $this->paid_amount, 2)),
            'notes'           => $this->notes,
            'terms'           => $this->terms,
            'items'           => $items,
            'metadata'        => $this->metadata,
            'customer'        => new CustomerResource($this->whenLoaded('customer') ?: $this->customer),
            'public_url'      => route('previewInvoice', $this->public_hash ?: $this->invoice_number),
            'pdf_url'         => url('/api/v1/invoices/' . $this->id . '/pdf'),
            'created_at'      => $this->created_at?->toIso8601String(),
            'updated_at'      => $this->updated_at?->toIso8601String(),
        ];
    }
}
