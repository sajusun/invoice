<?php

namespace App\Models;

use App\Traits\DynamicPaginatable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Customer extends Model
{
    use HasFactory, DynamicPaginatable;

    protected $table = 'customers';

    protected $fillable = [
        'user_id',
        'name',
        'company_name',
        'email',
        'phone',
        'tax_id',
        'address',
        'notes',
        'metadata',
    ];

    protected function casts(): array
    {
        return [
            'metadata' => 'array',
        ];
    }

    /**
     * Customer belongs to a user (account owner).
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Customer has many invoices.
     */
    public function invoices(): HasMany
    {
        return $this->hasMany(Invoice::class, 'customer_id');
    }

    /**
     * Scope to filter by arbitrary metadata key/value.
     */
    public function scopeWhereMetadata(Builder $query, string $key, mixed $value): Builder
    {
        return $query->where("metadata->{$key}", $value);
    }
}
