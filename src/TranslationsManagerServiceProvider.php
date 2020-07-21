<?php

namespace ilBronza\TranslationsManager;

use Illuminate\Support\ServiceProvider;

class TranslationsManagerServiceProvider extends ServiceProvider
{
    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot()
    {
        // $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'ilbronza');

        $this->loadViewsFrom(__DIR__.'/views', 'ilbronza');
        // $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
        $this->loadRoutesFrom(__DIR__.'/routes.php');

        // Publishing is only necessary when using the CLI.
        if ($this->app->runningInConsole()) {
            $this->bootForConsole();
        }
    }

    /**
     * Register any package services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/translationsmanager.php', 'translationsmanager');

        // Register the service the package provides.
        $this->app->singleton('translationsmanager', function ($app) {
            return new TranslationsManager;
        });

        $this->app->extend(\Illuminate\Translation\Translator::class, function ($translator) {
            return new \ilBronza\TranslationsManager\TranslationsManager($translator->getLoader(), $translator->getLocale());
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['TranslationsManager'];
    }

    /**
     * Console-specific booting.
     *
     * @return void
     */
    protected function bootForConsole()
    {
        // Publishing the configuration file.
        $this->publishes([
            __DIR__.'/../config/translationsmanager.php' => config_path('translationsmanager.php'),
        ], 'translationsmanager.config');

        // Publishing the views.
        /*$this->publishes([
            __DIR__.'/../resources/views' => base_path('resources/views/vendor/ilbronza'),
        ], 'TranslationsManager.views');*/

        // Publishing assets.
        /*$this->publishes([
            __DIR__.'/../resources/assets' => public_path('vendor/ilbronza'),
        ], 'TranslationsManager.views');*/

        // Publishing the translation files.
        /*$this->publishes([
            __DIR__.'/../resources/lang' => resource_path('lang/vendor/ilbronza'),
        ], 'TranslationsManager.views');*/

        // Registering package commands.
        // $this->commands([]);
    }
}
