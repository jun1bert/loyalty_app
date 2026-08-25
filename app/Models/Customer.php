<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $fillable = [
        'user_id',
        'first_name',
        'last_name',
        'phone',
        'birth_date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function loyaltyMembership()
    {
        return $this->hasOne(LoyaltyMembership::class);
    }
}