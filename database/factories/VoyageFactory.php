<?php

namespace Database\Factories;

use App\Models\Port;
use App\Models\Vessel;
use Illuminate\Database\Eloquent\Factories\Factory;

class VoyageFactory extends Factory
{
    public function definition()
    {
        return [
            'voyage_number' => 'VR-' . $this->faker->unique()->numberBetween(1000, 9999),
            'vessel_id' => Vessel::factory(),
            'departure_port_id' => Port::factory(),
            'arrival_port_id' => Port::factory(),
            'departure_time' => $this->faker->dateTimeBetween('+1 week', '+1 month'),
            'arrival_time' => $this->faker->dateTimeBetween('+1 month', '+2 months'),
            'passenger_capacity' => $this->faker->numberBetween(50, 300),
            'available_seats' => fn (array $attributes) => $this->faker->numberBetween(1, $attributes['passenger_capacity']),
            'price_per_seat' => $this->faker->numberBetween(50, 500),
            'type' => $this->faker->randomElement(['regular', 'cruise', 'charter']),
        ];
    }
}