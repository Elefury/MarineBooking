<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
        'bookable_type',
        'bookable_id',
        'stripe_payment_id',
        'amount',
        'status',
        'metadata'
    ];

    protected $casts = [
        'metadata' => 'array'
    ];

    public function bookable()
    {
        return $this->morphTo();
    }
}