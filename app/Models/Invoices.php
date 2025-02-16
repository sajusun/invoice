<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


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
}
