<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


/**
 * @property int $id
 * @property int $user_id
 * @property int $customer_id
 * @property string $invoice_number
 * @property string $invoice_date
 * @property string $items
 * @property string|null $notes
 * @property string $tax_amount
 * @property string $paid_amount
 * @property string $total_amount
 * @property string $status
 * @property int $need_tax
 * @property string $currency
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Customers $customer
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Invoices newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Invoices newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Invoices query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Invoices whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Invoices whereCurrency($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Invoices whereCustomerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Invoices whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Invoices whereInvoiceDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Invoices whereInvoiceNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Invoices whereItems($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Invoices whereNeedTax($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Invoices whereNotes($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Invoices wherePaidAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Invoices whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Invoices whereTaxAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Invoices whereTotalAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Invoices whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Invoices whereUserId($value)
 * @mixin \Eloquent
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
    protected $casts = [
        'items' => 'array', // JSON automatically array hoye jabe
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

}

