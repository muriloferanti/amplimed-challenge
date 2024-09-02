<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class WeatherService
{
    protected $apiKey;

    protected $apiUrl;

    public function __construct()
    {
        $this->apiUrl = config('services.weatherstack.url');
        $this->apiKey = config('services.weatherstack.key');
    }

    /**
     * @param string $location
     * @return array
     */
    public function getWeather($location)
    {
        $response = Http::get($this->apiUrl, [
            'access_key' => $this->apiKey,
            'query' => $location
        ]);

        if ($response->successful()) {
            $data = $response->json();

            if (isset($data['error'])) {
                return ['error' => $data['error']['info'] ?? 'Erro desconhecido'];
            }

            return $data;
        }

        return ['error' => 'Não foi possível obter o clima'];
    }
}
