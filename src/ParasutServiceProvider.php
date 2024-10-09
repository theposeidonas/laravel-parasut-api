<?php

namespace Theposeidonas\LaravelParasutApi;

use Illuminate\Support\ServiceProvider;

class ParasutServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any package services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'/../config/parasut.php' => config_path('parasut.php'),
        ], 'parasut-config');
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/parasut.php', 'parasut');
        $this->app->singleton(ParasutV4::class, function ($app) {
            return new ParasutV4($app['config']['parasut']);
        });
    }
}
