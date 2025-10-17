<?php

namespace App\Services;

use App\Models\CruiseLine;

class PricingCalculator
{
    public function calculate(CruiseLine $cruise)
    {
        $basePrice = $cruise->price_per_seat;
        $demandMultiplier = 1 + ($cruise->bookings()->count() / $cruise->total_seats);
        return round($basePrice * $demandMultiplier, 2);
    }
}
