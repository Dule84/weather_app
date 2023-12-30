<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class OpenWeatherMapService extends AbstractWeatherService
{
    public function getWeatherByLocation($lat, $lon)
    {
        $response = Http::get('https://api.openweathermap.org/data/3.0/onecall?lat='. $lat .'&lon='. $lon .'&exclude=minutely,hourly,daily,alerts&appid='. $this->apiKey);

        return $response->json();
    }
}
