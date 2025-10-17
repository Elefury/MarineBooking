<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class PortFactory extends Factory
{
    public function definition()
    {
        return [
            'name' => $this->faker->city . ' Port',
            'city' => $this->faker->city,
            'country' => $this->faker->country,
            'latitude' => $this->faker->latitude,
            'longitude' => $this->faker->longitude,
        ];
    }
}