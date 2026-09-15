<?php

namespace App\Http\Resources\Api\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $plan = $this->plan;

        return [
            'id'                => $this->id,
            'name'              => $this->name,
            'email'             => $this->email,
            'email_verified'    => (bool) $this->email_verified_at,
            'company_name'      => $this->settings?->company_name,
            'default_currency'  => $this->settings?->default_currency ?? 'USD',
            'plan'              => [
                'name'          => $plan?->name ?? 'Free',
                'type'          => $plan?->type ?? 'free',
                'max_invoices'  => $plan?->max_invoices,
                'max_customers' => $plan?->max_customers,
                'expires_at'    => $this->expires_at,
            ],
            'usage'             => [
                'total_invoices'  => $this->invoices()->count(),
                'total_customers' => $this->customers()->count(),
            ],
            'created_at'        => $this->created_at?->toIso8601String(),
        ];
    }
}
