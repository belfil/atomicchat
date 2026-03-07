<?php

declare(strict_types=1);

namespace Belfil\AtomicChat;

use Illuminate\Support\ServiceProvider;

class AtomicChatServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot(): void
    {
        /*
         * Optional methods to load your package assets
         */
        // $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'atomic-chat');
        // $this->loadViewsFrom(__DIR__.'/../resources/views', 'atomic-chat');
        // $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
        // $this->loadRoutesFrom(__DIR__.'/routes.php');

        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../config/atomic-chat.php' => config_path('atomic-chat.php'),
            ], 'config');

            // Publishing the views.
            /*$this->publishes([
                __DIR__.'/../resources/views' => resource_path('views/vendor/atomic-chat'),
            ], 'views');*/

            // Publishing assets.
            /*$this->publishes([
                __DIR__.'/../resources/assets' => public_path('vendor/atomic-chat'),
            ], 'assets');*/

            // Publishing the translation files.
            /*$this->publishes([
                __DIR__.'/../resources/lang' => resource_path('lang/vendor/atomic-chat'),
            ], 'lang');*/

            // Registering package commands.
            // $this->commands([]);
        }
    }

    /**
     * Register the application services.
     */
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/atomic-chat.php', 'atomic-chat');
        $this->app->singleton('atomic-chat', function () {
            return new AtomicChat;
        });
    }
}
