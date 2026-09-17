<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $id
 * @property string $name
 * @property string|null $slug
 * @property string $price
 * @property string $monthly_price
 * @property string $annual_price
 * @property int $annual_discount_percent
 * @property string $currency
 * @property string|null $description
 * @property array|null $features
 * @property string $type
 * @property int|null $max_invoices
 * @property int|null $max_customers
 * @property bool $has_api_access
 * @property bool $has_custom_branding
 * @property bool $has_recurring_invoices
 * @property bool $has_priority_support
 * @property bool $is_popular
 * @property bool $is_active
 * @property string|null $stripe_monthly_price_id
 * @property string|null $stripe_annual_price_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 */
class Plan extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'price',
        'monthly_price',
        'annual_price',
        'annual_discount_percent',
        'currency',
        'description',
        'features',
        'type',
        'max_invoices',
        'max_customers',
        'has_api_access',
        'has_custom_branding',
        'has_recurring_invoices',
        'has_priority_support',
        'is_popular',
        'is_active',
        'stripe_monthly_price_id',
        'stripe_annual_price_id',
    ];

    protected $casts = [
        'monthly_price' => 'decimal:2',
        'annual_price' => 'decimal:2',
        'price' => 'decimal:2',
        'annual_discount_percent' => 'integer',
        'features' => 'array',
        'has_api_access' => 'boolean',
        'has_custom_branding' => 'boolean',
        'has_recurring_invoices' => 'boolean',
        'has_priority_support' => 'boolean',
        'is_popular' => 'boolean',
        'is_active' => 'boolean',
    ];

    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }

    /**
     * Get monthly equivalent cost when billed annually.
     * E.g. $144 annual / 12 = $12.00 / month
     */
    public function getAnnualMonthlyEquivalentAttribute(): float
    {
        if ($this->annual_price <= 0) {
            return 0.00;
        }
        return round((float) $this->annual_price / 12, 2);
    }

    /**
     * Calculate yearly savings when choosing annual over monthly.
     * E.g. ($15 * 12) - $144 = $36 saved per year.
     */
    public function getAnnualSavingsAttribute(): float
    {
        $yearlyStandard = (float) $this->monthly_price * 12;
        $savings = $yearlyStandard - (float) $this->annual_price;
        return max(0, round($savings, 2));
    }

    /**
     * Helper to get price for a specific cycle.
     */
    public function getPriceForCycle(string $cycle = 'monthly'): float
    {
        return $cycle === 'annual' ? (float) $this->annual_price : (float) $this->monthly_price;
    }
}
