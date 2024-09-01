<?php

namespace App\Http\Controllers;

use App\Models\Search;
use App\Services\WeatherService;
use Illuminate\Support\Facades\Session;
use Illuminate\View\View;

class WeatherController extends Controller
{
    protected $weatherService;

    /**
     * @param WeatherService $weatherService
     */
    public function __construct(WeatherService $weatherService)
    {
        $this->weatherService = $weatherService;
    }

    /**
     * @param string $location
     * @return \Illuminate\View\View
     */
    public function show($location): View
    {
        $weatherData = $this->weatherService->getWeather($location);

        $search = Search::firstOrNew(
            [
                'city' => $weatherData['location']['name'],
                'country' => $weatherData['location']['country'],
                'session_id' => Session::getId()
            ]
        );
        $search->city = $weatherData['location']['name'];
        $search->country = $weatherData['location']['country'];
        $search->quantity += 1;
        $search->session_id = Session::getId();
        $search->save();

        return view('weather', ['weather' => $weatherData['current'], 'location' => $weatherData['location']]);
    }
}
