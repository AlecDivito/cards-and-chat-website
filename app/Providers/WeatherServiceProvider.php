<?php

namespace App\Providers;

use App\Repositories\IPGeolocationAPIRepository;
use App\Repositories\WeatherAPIRepository;
use Illuminate\Support\ServiceProvider;

class WeatherServiceProvider extends ServiceProvider
{
    protected $defer = true;

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(WeatherAPIRepository::class, function ($app) {
            return new WeatherAPIRepository(config('services.weather.key'));
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [
            'App\Repositories\WeatherAPIRepository',
            'App\Repositories\IPGeolocationAPIRepository',
        ];
    }
}
