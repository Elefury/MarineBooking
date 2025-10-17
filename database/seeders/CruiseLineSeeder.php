<?php

namespace Database\Seeders;

use App\Models\CruiseLine;
use Illuminate\Database\Seeder;

class CruiseLineSeeder extends Seeder
{
    public function run()
    {
        CruiseLine::create([
            'name' => 'Alaska Adventure',
            'description' => '10-day cruise through Alaska',
            'departure_time' => now()->addDays(30),
            'total_seats' => 200,
            'available_seats' => 200,
            'price_per_seat' => 2500.00
        ]);
    }
}
