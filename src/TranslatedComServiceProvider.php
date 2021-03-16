<?php

namespace Marshmallow\TranslatedCom;

use Illuminate\Support\ServiceProvider;
use Marshmallow\TranslatedCom\Console\Commands\TestTranslation;

class TranslatedComServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__ . '/../config/translated-com.php',
            'translated-com'
        );

        if ($this->app->runningInConsole()) {
            $this->commands([
                TestTranslation::class,
            ]);
        }
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');

        /*
         * Publish config
         */
        $this->publishes([
            __DIR__ . '/../config/translated-com.php' => config_path('translated-com.php'),
        ]);

        /**
         * Load routes
         */
        $this->loadRoutesFrom(__DIR__ . '/../routes/routes.php');
    }
}
