<?php

namespace App\Factories;

class WeatherServiceFactory
{
    public static function create()
    {
        $serviceName = config('weather.service');
        $apiKey = config('weather.api_key');

        $className = '\\App\\Services\\' . $serviceName . 'Service';
        if (class_exists($className)) {
            return new $className($apiKey);
        } else {
            throw new \InvalidArgumentException("Unsupported weather service: $serviceName");
        }
    }
}
