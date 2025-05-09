<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


/**
 * @method static create(array $array)
 * @method static where(string $string, int|string|null $id)
 */
class Invoices extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'customer_id',
        'invoice_number',
        'invoice_date',
        'items',
        "paid_amount",
        "total_amount",
        "notes",
        "need_tax",
        "tax_amount",
        "currency",
        "status"
    ];

    // An invoice belongs to a customer
    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customers::class);
    }

    // An invoice belongs to a user (creator)
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

//    protected static function booted(): void
//    {
//        static::creating(function ($invoice) {
//            $invoice->payment_status = $invoice->paid_amount >= $invoice->total_amount ? 'Paid' : 'Pending';
//        });
//
//        static::updating(function ($invoice) {
//            $invoice->payment_status = $invoice->paid_amount >= $invoice->total_amount ? 'Paid' : 'Pending';
//        });
//    }
}

