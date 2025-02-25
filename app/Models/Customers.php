<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;


/**
 * @method static create(array $array)
 * @method static get(string $string)
 * @method static find(string $id, string[] $array)
 */
class Customers extends Model
{
    use HasFactory;
    protected $fillable=[
        'user_id',
        'name',
        'phone',
    ];

    // A customer can have multiple invoices
    public function invoices(): HasMany {
        return $this->hasMany(Invoices::class, 'customer_id', 'id');
    }
}
