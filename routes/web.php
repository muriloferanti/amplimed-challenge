<?php

use App\Http\Controllers\WeatherController;
use App\Http\Controllers\WeatherRecordController;
use App\Http\Controllers\ZipCodeController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::group(['middleware' => ['web']], function () {
    Route::get('/', function () {
        return view('home');
    });

    Route::get('/zip-code/{zipCode}', [ZipCodeController::class, 'show'])->name('zipcode.show');

    Route::get('/weather/{location}', [WeatherController::class, 'show'])->name('weather.show');

    Route::get('/weather-records', [WeatherRecordController::class, 'index'])->name('weather-records');

    Route::get('/weather-compare', [WeatherRecordController::class, 'compare'])->name('weather-compare');

    Route::get('/weather-records-latest', [WeatherRecordController::class, 'latest'])->name('weather-records-latest');

    Route::post('/weather-records/{location}', [WeatherRecordController::class, 'store']);
});
