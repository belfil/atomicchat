<?php

declare(strict_types=1);

use Belfil\AtomicChat\Stream\Builders\CoreMessageBuilder;
use Illuminate\Support\ServiceProvider;
use Private\Builders\PrivateChat;

class ServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot(): void
    {
        //        $this->app->bind(ChatProxy::class, function ($app, $params) {
        //            return new ChatProxy($params['actor']);
        //        });
        $this->app->bind(PrivateChat::class, function($app, $params) {
            $chat = $params['chat'] ?? (new (config('atomic-chat.core.models.chat.class')));
            return new PrivateChat($chat);
        });
        $this->app->bind(CoreMessageBuilder::class, function($app, $params) {
            $message = $params['message'] ?? (new (config('atomic-chat.core.models.message.class')));
            return new CoreMessageBuilder($message);
        });
        /*
         * Optional methods to load your package assets
         */
        // $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'atomic-chat');
        // $this->loadViewsFrom(__DIR__.'/../resources/views', 'atomic-chat');
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');
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
        $this->mergeConfigFrom(__DIR__ . '/../../config/atomic-chat.php', 'atomic-chat');
        $this->registerFeatures();
    }

    protected function registerFeatures(): void
    {
        $modules = config('atomic-chat.modules', []);
        foreach ($modules as $module => $settings) {
            if ($settings['enabled'] ?? false) {
                $this->app->register($this->getModuleProvider($module));
            }
        }
    }
}
