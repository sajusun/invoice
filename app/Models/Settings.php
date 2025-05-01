<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Settings extends Model
{
    protected $fillable = [
        'user_id',
        'company_name',
        'company_email',
        'company_phone',
        'company_address',
        'default_currency',
        'default_tax_rate',
        'invoice_prefix',
        'start_number',
        'show_tax_column',
        'show_email_column'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
