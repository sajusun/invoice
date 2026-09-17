<?php

namespace App\Models;

use App\Traits\DynamicPaginatable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class Invoice extends Model
{
    use HasFactory, DynamicPaginatable;

    protected $table = 'invoices';

    protected $fillable = [
        'uuid',
        'public_hash',
        'user_id',
        'customer_id',
        'invoice_number',
        'invoice_date',
        'due_date',
        'items',
        'subtotal',
        'tax_amount',
        'discount_amount',
        'discount_type',
        'paid_amount',
        'total_amount',
        'currency',
        'status',
        'need_tax',
        'notes',
        'terms',
        'metadata',
        'is_recurring',
        'recurring_frequency',
        'recurring_end_date',
        'last_recurring_at',
    ];

    protected function casts(): array
    {
        return [
            'items' => 'array',
            'metadata' => 'array',
            'invoice_date' => 'date',
            'due_date' => 'date',
            'recurring_end_date' => 'date',
            'last_recurring_at' => 'date',
            'is_recurring' => 'boolean',
            'subtotal' => 'decimal:2',
            'tax_amount' => 'decimal:2',
            'discount_amount' => 'decimal:2',
            'paid_amount' => 'decimal:2',
            'total_amount' => 'decimal:2',
            'need_tax' => 'boolean',
        ];
    }

    protected static function booted(): void
    {
        static::creating(function (Invoice $invoice) {
            if (empty($invoice->uuid)) {
                $invoice->uuid = (string) Str::uuid();
            }
            if (empty($invoice->public_hash)) {
                $invoice->public_hash = bin2hex(random_bytes(32));
            }
        });
    }

    /**
     * An invoice belongs to a customer.
     */
    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    /**
     * An invoice belongs to a user (issuer).
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Calculate outstanding balance.
     */
    public function getDueAmountAttribute(): float
    {
        return (float) max(0, round((float) $this->total_amount - (float) $this->paid_amount, 2));
    }

    /**
     * Check if invoice is fully paid.
     */
    public function isPaid(): bool
    {
        return $this->status === 'paid' || ((float) $this->paid_amount >= (float) $this->total_amount && (float) $this->total_amount > 0);
    }

    /**
     * Check if invoice is overdue.
     */
    public function isOverdue(): bool
    {
        return $this->status === 'overdue' ||
            (!$this->isPaid() && $this->due_date && $this->due_date->isPast());
    }

    /**
     * Scope to filter by arbitrary metadata key/value.
     */
    public function scopeWhereMetadata(Builder $query, string $key, mixed $value): Builder
    {
        return $query->where("metadata->{$key}", $value);
    }
}
