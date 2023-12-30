<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Contracts\View\View;
use App\Factories\WeatherServiceFactory;
use App\Http\Requests\LatitudeAndLongitudeRequest;

class WeatherController extends Controller
{
    public function index(): View
    {
        return view('welcome');
    }

    public function getWeatherByLatAndLon(LatitudeAndLongitudeRequest $request): JsonResponse
    {
        $weatherService = WeatherServiceFactory::create();
        $response = $weatherService->getWeatherByLocation($request->latitude, $request->longitude);

        unset($weatherService);

        return response()->json(['data' => $response]);
    }
}
