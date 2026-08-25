<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LoyaltyMembership extends Model
{
    protected $fillable = [
        'customer_id',
        'loyalty_plan_id',
        'membership_code',
        'qr_token',
        'activated_at',
        'expires_at',
        'status',
    ];

    protected $casts = [
        'activated_at' => 'datetime',
        'expires_at' => 'datetime',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function loyaltyPlan()
    {
        return $this->belongsTo(LoyaltyPlan::class);
    }
}