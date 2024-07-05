<?php

namespace JuniorFontenele\LaravelVersion;

use Illuminate\Support\ServiceProvider;

class LaravelVersionServiceProvider extends ServiceProvider
{
    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot(): void
    {
        // $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'juniorfontenele');
        // $this->loadViewsFrom(__DIR__.'/../resources/views', 'juniorfontenele');
        // $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
        // $this->loadRoutesFrom(__DIR__.'/routes.php');

        // Publishing is only necessary when using the CLI.
        if ($this->app->runningInConsole()) {
            $this->bootForConsole();
        }

        config(['laravel-version.version' => LaravelVersion::version()]);
    }

    /**
     * Register any package services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__.'/../config/laravel-version.php', 'laravel-version');

        // Register the service the package provides.
        $this->app->singleton('laravel-version', function ($app) {
            return new LaravelVersion;
        });

    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['laravel-version'];
    }

    /**
     * Console-specific booting.
     *
     * @return void
     */
    protected function bootForConsole(): void
    {
        // Publishing the configuration file.
        $this->publishes([
            __DIR__.'/../config/laravel-version.php' => config_path('laravel-version.php'),
        ], 'laravel-version.config');

        // Publishing the views.
        /*$this->publishes([
            __DIR__.'/../resources/views' => base_path('resources/views/vendor/juniorfontenele'),
        ], 'laravel-version.views');*/

        // Publishing assets.
        /*$this->publishes([
            __DIR__.'/../resources/assets' => public_path('vendor/juniorfontenele'),
        ], 'laravel-version.assets');*/

        // Publishing the translation files.
        /*$this->publishes([
            __DIR__.'/../resources/lang' => resource_path('lang/vendor/juniorfontenele'),
        ], 'laravel-version.lang');*/

        // Registering package commands.
        // $this->commands([]);
    }
}
