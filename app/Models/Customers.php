<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;


/**
 * @property int $id
 * @property int $user_id
 * @property string $name
 * @property string|null $email
 * @property string $phone
 * @property string|null $address
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Invoices> $invoices
 * @property-read int|null $invoices_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Customers newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Customers newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Customers query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Customers whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Customers whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Customers whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Customers whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Customers whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Customers wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Customers whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Customers whereUserId($value)
 * @mixin \Eloquent
 */
class Customers extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'phone',
        'address',
        'email'
    ];

    // A customer can have multiple invoices
    public function invoices(): HasMany
    {
        return $this->hasMany(Invoices::class, 'customer_id', 'id');
    }
}
