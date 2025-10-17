<?php

namespace Database\Factories;

use App\Models\Booking;
use App\Models\CruiseLine;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class BookingFactory extends Factory
{
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'cruise_line_id' => CruiseLine::factory(),
            'seats' => fake()->numberBetween(1, 5),
            'total_price' => fake()->randomFloat(2, 100, 5000),
            'status' => 'confirmed',
            'created_at' => fake()->dateTimeBetween('-1 year'),
        ];
    }
}
