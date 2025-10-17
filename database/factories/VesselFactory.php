<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class VesselFactory extends Factory
{
    public function definition()
    {
        return [
            'name' => $this->faker->name . ' ' . $this->faker->randomElement(['Express', 'Voyager', 'Mariner']),
            'type' => $this->faker->randomElement(['ferry', 'yacht', 'speedboat', 'cruise']),
            'capacity' => $this->faker->numberBetween(50, 500),
            'description' => $this->faker->paragraph,
        ];
    }
}