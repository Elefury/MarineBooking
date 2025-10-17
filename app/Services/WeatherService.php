<?php

namespace App\Services;

use App\Models\CruiseLine;
use Illuminate\Support\Facades\Http;

class WeatherService
{
    public function getForecast(CruiseLine $cruise)
    {
        $response = Http::get('https://api.weatherapi.com/v1/forecast.json', [
            'key' => config('services.weather.key'),
            'q' => $cruise->destination_coordinates,
            'days' => 2
        ]);

        return $response->json()['forecast']['forecastday'] ?? null;
    }
}
