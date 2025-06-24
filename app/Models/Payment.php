<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{

    protected $fillable = [
        'user_id',
        'plan_id',
        'payment_method',
        'amount',
        'payment_status',
    ];

    // Relationship: Payment belongs to a user
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relationship: Payment belongs to a plan
    public function plan()
    {
        return $this->belongsTo(Plan::class);
    }
}
