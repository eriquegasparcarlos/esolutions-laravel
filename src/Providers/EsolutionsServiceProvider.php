<?php

namespace Esolutions\Laravel\Providers;

use Illuminate\Support\ServiceProvider;

class EsolutionsServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->mergeConfigFrom(
            __DIR__ . '/../../config/esolutions.php',
            'esolutions'
        );
    }

    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../../config/esolutions.php' => config_path('esolutions.php'),
            ], 'esolutions-config');
        }
    }
}
