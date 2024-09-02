<?php

namespace Database\Factories;

use App\Models\Search;
use Illuminate\Database\Eloquent\Factories\Factory;

class SearchFactory extends Factory
{
    protected $model = Search::class;

    public function definition()
    {
        return [
            'city' => $this->faker->city,
            'country' => $this->faker->country,
            'quantity' => $this->faker->numberBetween(1, 100),
            'session_id' => $this->faker->uuid,
        ];
    }
}
