<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PromoCode extends Model
{
    protected $fillable = [
        'code', 'type', 'value', 
        'valid_from', 'valid_to', 
        'usage_limit', 'used_count'
    ];

    public function isValid()
    {
        return now()->between($this->valid_from, $this->valid_to) &&
               ($this->usage_limit === null || $this->used_count < $this->usage_limit);
    }

    public function applyDiscount($amount)
    {
        return $this->discount_type === 'percent' 
            ? $amount * (1 - $this->discount_value/100)
            : max($amount - $this->discount_value, 0);
    }
    public function scopeValid($query)
    {
        return $query->where('valid_from', '<=', now())
            ->where('valid_to', '>=', now())
            ->whereRaw('usage_limit > used_count OR usage_limit IS NULL');
    }
}
