<?php

namespace Database\Factories;

use App\Models\WeatherRecord;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class WeatherRecordFactory extends Factory
{
    protected $model = WeatherRecord::class;

    public function definition()
    {
        return [
            'session_id' => Str::random(10),
            'country' => $this->faker->country,
            'city' => $this->faker->city,
            'temperature' => $this->faker->numberBetween(-10, 40),
            'weather_code' => $this->faker->numberBetween(100, 999), // Garante que seja um inteiro
            'weather_icons' => json_encode([$this->faker->imageUrl]),
            'weather_descriptions' => json_encode([$this->faker->sentence]),
            'wind_speed' => $this->faker->numberBetween(0, 100),
            'humidity' => $this->faker->numberBetween(0, 100),
            'cloudcover' => $this->faker->numberBetween(0, 100),
        ];
    }
}
