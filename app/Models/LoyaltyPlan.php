<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LoyaltyPlan extends Model
{
    protected $fillable = [
        'name',
        'price',
        'discount_percentage',
        'minimum_spend',
        'validity_months',
        'is_active',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'discount_percentage' => 'decimal:2',
        'minimum_spend' => 'decimal:2',
        'is_active' => 'boolean',
    ];

    public function memberships()
    {
        return $this->hasMany(LoyaltyMembership::class);
    }
}
