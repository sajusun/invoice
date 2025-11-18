<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Invoice_Items newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Invoice_Items newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Invoice_Items query()
 * @mixin \Eloquent
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
