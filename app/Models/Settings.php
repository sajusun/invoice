<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property int $user_id
 * @property string $company_name
 * @property string|null $company_email
 * @property string|null $company_phone
 * @property string|null $company_address
 * @property string|null $company_logo
 * @property string $default_currency
 * @property string|null $default_tax_rate
 * @property int $show_tax_column
 * @property int $show_email_column
 * @property string $invoice_prefix
 * @property int $start_number
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Settings newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Settings newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Settings query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Settings whereCompanyAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Settings whereCompanyEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Settings whereCompanyLogo($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Settings whereCompanyName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Settings whereCompanyPhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Settings whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Settings whereDefaultCurrency($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Settings whereDefaultTaxRate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Settings whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Settings whereInvoicePrefix($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Settings whereShowEmailColumn($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Settings whereShowTaxColumn($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Settings whereStartNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Settings whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Settings whereUserId($value)
 * @mixin \Eloquent
 */
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
