<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LoyaltyTransaction extends Model
{
    protected $fillable = [
        'customer_id',
        'loyalty_membership_id',
        'processed_by',
        'subtotal',
        'eligible_subtotal',
        'discount_percentage',
        'discount_amount',
        'total_amount',
        'transaction_date',
    ];

    protected $casts = [
        'subtotal' => 'decimal:2',
        'eligible_subtotal' => 'decimal:2',
        'discount_percentage' => 'decimal:2',
        'discount_amount' => 'decimal:2',
        'total_amount' => 'decimal:2',
        'transaction_date' => 'datetime',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function membership()
    {
        return $this->belongsTo(
            LoyaltyMembership::class,
            'loyalty_membership_id'
        );
    }

    public function processedBy()
    {
        return $this->belongsTo(User::class, 'processed_by');
    }

    public function items()
    {
        return $this->hasMany(LoyaltyTransactionItem::class);
    }
}