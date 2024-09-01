<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class ViaCepService
{
    protected $apiUrl;

    public function __construct()
    {
        $this->apiUrl = config('services.viacep.url');
    }

    /**
     * @param string $zipCode
     * @return array
     */
    public function getAddress($zipCode)
    {
        $response = Http::get("{$this->apiUrl}/{$zipCode}/json/");

        if ($response->successful()) {
            $data = $response->json();
            if (!isset($data['erro'])) {
                return $data;
            }
        }

        return ['error' => 'Não foi possível obter o endereço'];
    }
}
