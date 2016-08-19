<?php

namespace RonasIT\Support;
use Illuminate\Support\ServiceProvider;

class SharedDataServiceProvider extends ServiceProvider
{
    public function boot() {
        $this->publishes([
            __DIR__.'/../config/shared-data.php' => config_path('shared-data.php'),
        ], 'config');

        $this->publishes([
            __DIR__.'/../src/Services/SharedDataService.php' => app_path('Services/SharedDataService.php'),
        ], 'config');
    }

    public function register()
    {

    }
}