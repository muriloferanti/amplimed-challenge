<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WeatherRecord extends Model
{
    use HasFactory;

    protected $casts = [
        'weather_icons' => 'array',
        'weather_descriptions' => 'array'
    ];

    protected $fillable = [
        'session_id',
        'country',
        'city',
        'temperature',
        'weather_code',
        'weather_icons',
        'weather_descriptions',
        'wind_speed',
        'humidity',
        'cloudcover',
        'saved_at'
    ];

    /**
     * @return bool
     */
    public function canBeSaved()
    {
        $currentTimestamp = Carbon::now();
        $savedAt = new Carbon($this->saved_at);
        $diffInHours = $currentTimestamp->diffInHours($savedAt);

        return $diffInHours > 1;
    }
}
