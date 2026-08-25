<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LoyaltyPlan extends Model
{
    protected $fillable = [
        'name',
        'price',
        'discount_percentage',
        'validity_months',
        'is_active',
    ];

    public function memberships()
    {
        return $this->hasMany(LoyaltyMembership::class);
    }
}