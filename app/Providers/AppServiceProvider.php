<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Hashids\Hashids;

class AppServiceProvider extends ServiceProvider
{

    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $hashids = new Hashids(env('HASHIDS_SALT', 'your-salt-key'), 10);
        app()->instance('hashids', $hashids);
    }
}
