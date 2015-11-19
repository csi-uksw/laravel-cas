<?php

namespace CSI_UKSW\Laravel\CAS;

use Illuminate\Support\ServiceProvider;

class CASServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application.
     *
     * @return void
     */
    public function boot()
    {
        // load translations
        $this->loadTranslationsFrom(__DIR__ . '/lang', 'cas');

        // publish translations
        $this->publishes([
            __DIR__ . '/lang/' => base_path('resources/lang'),
        ], 'lang');

        // publish config
        $this->publishes([
            __DIR__ . '/config/cas.php' => config_path('cas.php'),
        ], 'config');
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['cas'];
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bindShared('cas', function () {
            return new CASManager();
        });
    }
}