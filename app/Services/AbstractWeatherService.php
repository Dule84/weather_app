<?php

namespace App\Services;

abstract class AbstractWeatherService
{
    protected string $apiKey;

    public function __construct($apiKey) {
        $this->apiKey = $apiKey;
    }

    abstract public function getWeatherByLocation($lat, $lon);
}
