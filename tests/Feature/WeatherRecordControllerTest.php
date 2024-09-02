<?php

namespace Tests\Feature;

use App\Models\WeatherRecord;
use App\Services\WeatherService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Session;
use Tests\TestCase;

class WeatherRecordControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Testa a exibição dos registros de clima.
     *
     * @return void
     */
    public function testIndex()
    {
        WeatherRecord::factory()->count(3)->create([
            'session_id' => Session::getId()
        ]);

        $response = $this->get('/weather-records');

        $response->assertStatus(200)
            ->assertViewIs('weather-records');
    }

    /**
     * Testa a comparação dos registros de clima.
     *
     * @return void
     */
    public function testCompare()
    {
        $record = WeatherRecord::factory()->create([
            'session_id' => Session::getId()
        ]);

        $encodedId = app('hashids')->encode($record->id);

        $response = $this->get('/weather-compare?ids[]=' . $encodedId);

        $response->assertStatus(200)
            ->assertJsonFragment([
                'city' => $record->city
            ]);
    }

    /**
     * Testa a obtenção dos registros de clima mais recentes.
     *
     * @return void
     */
    public function testLatest()
    {
        WeatherRecord::factory()->count(5)->create([
            'session_id' => Session::getId()
        ]);

        $response = $this->get('/weather-records-latest');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'success',
                'records' => [
                    '*' => [
                        'city',
                        'temperature',
                        'wind_speed',
                        'saved_at'
                    ]
                ]
            ]);
    }

    /**
     * Testa o armazenamento dos registros de clima.
     *
     * @return void
     */
    public function testStore()
    {
        $location = 'São Paulo';

        // Mockar a resposta do serviço de clima
        $this->mock(WeatherService::class, function ($mock) use ($location) {
            $mock->shouldReceive('getWeather')
                ->with($location)
                ->andReturn([
                    'location' => ['name' => $location, 'country' => 'Brazil'],
                    'current' => [
                        'temperature' => 25,
                        'weather_code' => '113',
                        'weather_icons' => ['icon_url'],
                        'weather_descriptions' => ['clear sky'],
                        'wind_speed' => 10,
                        'humidity' => 60,
                        'cloudcover' => 0
                    ]
                ]);
        });

        // Enviar a requisição POST com o parâmetro no corpo da requisição
        $response = $this->postJson('/weather-records', ['location' => $location]);

        $response->assertStatus(201)
            ->assertJson([
                'status' => 'success',
                'message' => 'Dados do clima salvos com sucesso!'
            ]);

        // Verificar se o registro foi salvo na base de dados
        $this->assertDatabaseHas('weather_records', [
            'city' => $location,
            'country' => 'Brazil'
        ]);
    }
}
