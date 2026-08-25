<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LoyaltyTransactionItem extends Model
{
    protected $fillable = [
        'loyalty_transaction_id',
        'service_id',
        'service_name',
        'original_price',
        'discount_eligible',
        'discount_amount',
        'final_price',
    ];

    protected $casts = [
        'original_price' => 'decimal:2',
        'discount_eligible' => 'boolean',
        'discount_amount' => 'decimal:2',
        'final_price' => 'decimal:2',
    ];

    public function transaction()
    {
        return $this->belongsTo(LoyaltyTransaction::class);
    }

    public function service()
    {
        return $this->belongsTo(Service::class);
    }
}