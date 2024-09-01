<?php

namespace App\Http\Controllers;

use App\Models\WeatherRecord;
use App\Services\WeatherService;
use Carbon\Carbon;
use Hashids\Hashids;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;

class WeatherRecordController extends Controller
{
    protected $weatherService;
    private $hashids = null;

    /**
     * @param WeatherService $weatherService
     */
    public function __construct(WeatherService $weatherService)
    {
        $this->weatherService = $weatherService;
        $this->hashids = app('hashids');
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function compare(Request $request): JsonResponse
    {
        $encodedIds = $request->input('ids');
        $decodedIds = [];

        foreach ($encodedIds as $encodedId) {
            $decodedIds[] = $this->hashids->decode($encodedId);
        }

        if (empty($decodedIds)) {
            return response()->json(['success' => false, 'message' => 'IDs inválidos.']);
        }

        $records = WeatherRecord::whereIn('id', $decodedIds)->get();

        return response()->json([
            'success' => true,
            'records' => $records->map(function ($record) {
                return [
                    'city' => $record->city,
                    'country' => $record->country,
                    'temperature' => $record->temperature,
                    'weather_code' => $record->weather_code,
                    'weather_icons' => json_decode($record->weather_icons),
                    'weather_descriptions' => json_decode($record->weather_descriptions),
                    'wind_speed' => $record->wind_speed,
                    'humidity' => $record->humidity,
                    'cloudcover' => $record->cloudcover,
                    'uv_index' => $record->uv_index,
                    'saved_at' => Carbon::parse($record->saved_at)
                ];
            })
        ]);
    }

    /**
     * @return View
     */
    public function index(): View
    {
        $records = WeatherRecord::where('session_id', Session::getId())
            ->orderBy('saved_at', 'desc')
            ->get()
            ->groupBy(function ($item) {
                return $item->country . '|' . $item->city;
            });

        $hashids = $this->hashids;
        $latestRecords = $records->map(function ($group) use ($hashids) {
            $record = $group->first();
            $record->saved_at = Carbon::parse($record->saved_at);
            $record->encoded_id = $this->hashids->encode($record->id);

            return $record;
        });

        return view('weather-records', [
            'latestRecords' => $latestRecords,
            'allRecords' => $records
        ]);
    }

    /**
     * @return JsonResponse
     */
    public function latest(): JsonResponse
    {
        $sessionId = Session::getId();

        $latestRecords = WeatherRecord::where('session_id', $sessionId)
            ->orderBy('saved_at', 'desc')
            ->get()
            ->map(function ($record) {
                $record->saved_at = Carbon::parse($record->saved_at)->toDateTimeString();
                $record->id = $this->hashids->encode($record->id);

                return $record;
            });

        $latestRecords = $latestRecords->unique(function ($item) {
            return $item->city . $item->country;
        })->values()->take(10);

        return response()->json([
            'success' => true,
            'records' => $latestRecords->map(function ($record) {
                return [
                    'city' => $record->city,
                    'temperature' => $record->temperature,
                    'wind_speed' => $record->wind_speed,
                    'saved_at' => $record->saved_at
                ];
            })
        ]);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        $location = $request->input('location');

        $weatherData = $this->weatherService->getWeather($location);

        if (isset($weatherData['location']['country']) && $weatherData['location']['name']) {
            $existingRecord = WeatherRecord::where('session_id', Session::getId())
                ->where('country', $weatherData['location']['country'])
                ->where('city', $weatherData['location']['name'])
                ->first();

            if ($existingRecord && !$existingRecord->canBeSaved()) {
                return response()->json([
                    'status' => 'info',
                    'message' => 'Dados do clima já foram salvos recentemente!'
                ], 403);
            }

            WeatherRecord::create([
                'session_id' => Session::getId(),
                'country' => $weatherData['location']['country'],
                'city' => $weatherData['location']['name'],
                'temperature' => $weatherData['current']['temperature'],
                'weather_code' => $weatherData['current']['weather_code'],
                'weather_icons' => json_encode($weatherData['current']['weather_icons']),
                'weather_descriptions' => json_encode($weatherData['current']['weather_descriptions']),
                'wind_speed' => $weatherData['current']['wind_speed'],
                'humidity' => $weatherData['current']['humidity'],
                'cloudcover' => $weatherData['current']['cloudcover']
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'Dados do clima salvos com sucesso!'
            ], 201);
        }

        return response()->json([
            'status' => 'error',
            'message' => 'Não há dados de clima para salvar.'
        ], 400);
    }
}
