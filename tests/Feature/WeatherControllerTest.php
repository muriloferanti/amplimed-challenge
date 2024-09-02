<?php

namespace Tests\Feature;

use App\Models\Search;
use App\Services\WeatherService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Session;
use Tests\TestCase;

class WeatherControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Testa a exibição dos dados do clima para uma localização válida.
     *
     * @return void
     */
    public function testShowWithValidLocation()
    {
        $location = 'São Paulo';

        // Mockar a resposta do serviço de clima
        $this->mock(WeatherService::class, function ($mock) use ($location) {
            $mock->shouldReceive('getWeather')
                ->with($location)
                ->andReturn([
                    'location' => ['name' => $location, 'country' => 'BR'],
                    'current' => ['temperature' => 25, 'weather_code' => 'clear']
                ]);
        });

        $response = $this->get('/weather/' . $location);

        $response->assertStatus(200)
            ->assertViewIs('weather')
            ->assertViewHas('weather', [
                'temperature' => 25,
                'weather_code' => 'clear'
            ]);
    }

    /**
     * Testa o comportamento quando o serviço de clima retorna um erro.
     *
     * @return void
     */
    public function testShowWithWeatherServiceError()
    {
        $location = 'Cidade não existente';

        $this->mock(WeatherService::class, function ($mock) use ($location) {
            $mock->shouldReceive('getWeather')
                ->with($location)
                ->andReturn(['error' => 'Não foi possível obter o clima']);
        });

        $response = $this->get('/weather/' . $location);

        $response->assertStatus(200)
            ->assertViewIs('errors.weather')
            ->assertSee('Ocorreu um erro')
            ->assertSee('Erro ao conectar na API ou encontrar localização');
    }

    /**
     * Testa o incremento da quantidade de buscas para uma localização.
     *
     * @return void
     */
    public function testSearchIncrement()
    {
        $location = 'São Paulo';

        $this->mock(WeatherService::class, function ($mock) use ($location) {
            $mock->shouldReceive('getWeather')
                ->with($location)
                ->andReturn([
                    'location' => ['name' => $location, 'country' => 'Brazil'],
                    'current' => ['temperature' => 25, 'weather_code' => 'clear']
                ]);
        });

        $search = Search::firstOrNew(
            [
                'city' => $location,
                'country' => 'Brazil',
                'session_id' => Session::getId()
            ]
        );
        $search->city = $location;
        $search->country = 'Brazil';
        $search->quantity += 1;
        $search->session_id = Session::getId();
        $search->save();

        $response = $this->get('/weather/' . $location);
        
        $response->assertStatus(200);

        $this->assertDatabaseHas('searches', [
            'city' => $location,
            'country' => 'Brazil',
            'quantity' => 1
        ]);
    }

}
