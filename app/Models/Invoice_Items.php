<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static create(array $array)
 */
class Invoice_Items extends Model
{
    use HasFactory;
    protected $fillable=[
        'invoice_id',
        'description',
        'quantity',
        'unit_price',
    ];
}
