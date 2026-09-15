<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ApiKey extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'public_key',
        'secret_key_hash',
        'secret_preview',
        'scopes',
        'last_used_at',
        'expires_at',
        'is_active',
    ];

    protected $casts = [
        'scopes'       => 'array',
        'is_active'    => 'boolean',
        'last_used_at' => 'datetime',
        'expires_at'   => 'datetime',
    ];

    protected $hidden = [
        'secret_key_hash',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function hasScope(string $scope): bool
    {
        if (empty($this->scopes) || in_array('*', $this->scopes)) {
            return true;
        }

        return in_array($scope, $this->scopes);
    }
}
