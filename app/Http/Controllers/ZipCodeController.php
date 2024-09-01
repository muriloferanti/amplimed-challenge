<?php

namespace App\Http\Controllers;

use App\Services\ViaCepService;
use Illuminate\Http\JsonResponse;

class ZipCodeController extends Controller
{
    protected $viaCepService;

    /**
     * @param ViaCepService $viaCepService
     */
    public function __construct(ViaCepService $viaCepService)
    {
        $this->viaCepService = $viaCepService;
    }

    /**
     * @param string $zipCode
     * @return JsonResponse
     */
    public function show($zipCode): JsonResponse
    {
        $zipCode = str_replace('-', '', $zipCode);

        if (!preg_match('/^\d{8}$/', $zipCode)) {
            return response()->json(['error' => 'Código postal inválido'], 400);
        }

        $addressData = $this->viaCepService->getAddress($zipCode);

        if (isset($addressData['error'])) {
            return response()->json(['error' => 'Erro ao consultar código postal'], 400);
        }

        return response()->json([
            'city' => $addressData['localidade'],
            'state' => $addressData['uf']
        ]);
    }
}
