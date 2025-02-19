<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;


/**
 * @method static create(array $array)
 */
class Invoices extends Model
{
    use HasFactory;
    protected $fillable=[
        'client_id',
        'invoice_date',
        "total_amount"
    ];

    // An invoice belongs to a customer
    public function customer(): BelongsTo {
        return $this->belongsTo(Customers::class);
    }

    // An invoice belongs to a user (creator)
    public function user(): BelongsTo {
        return $this->belongsTo(User::class);
    }
}

