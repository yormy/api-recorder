<?php

namespace Yormy\ApiIoTracker;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Routing\Router;
use Illuminate\Support\ServiceProvider;
use Yormy\ApiIoTracker\Http\Middleware\LogIncomingRequest;
use Yormy\ApiIoTracker\ServiceProviders\EventServiceProvider;
use Yormy\ApiIoTracker\ServiceProviders\RouteServiceProvider;
use Yormy\ApiIoTracker\Services\Clients\StripeCurlClient;

class ApiIoTrackerServiceProvider extends ServiceProvider
{
    const CONFIG_FILE = __DIR__.'/../config/api-io-tracker.php';

    const CONFIG_IDE_HELPER_FILE = __DIR__.'/../config/ide-helper.php';

    /**
     * @psalm-suppress MissingReturnType
     */
    public function boot(Router $router)
    {
        $this->publish();

        $this->registerCommands();

        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');

        $this->registerMiddleware($router);

        $this->registerListeners();

        $this->loadViewsFrom(__DIR__.'/../resources/views', 'api-io-tracker');

        $this->registerTranslations();

        // need to use a singleton, otherwise at the terminate of the middleware
        // a new instance is created and the models are lost
        $this->app->singleton(LogIncomingRequest::class);

        if (config('api-io-tracker.stripe.enabled', false)) {
            $stripeCurlClient = new StripeCurlClient();
            \Stripe\ApiRequestor::setHttpClient($stripeCurlClient);
        }

        if (! defined('LARAVEL_START')) {
            define('LARAVEL_START', microtime(true));
        }
    }

    /**
     * @psalm-suppress MixedArgument
     */
    public function register()
    {
        $this->mergeConfigFrom(static::CONFIG_FILE, 'api-io-tracker');
        $this->mergeConfigFrom(static::CONFIG_IDE_HELPER_FILE, 'ide-helper');

        $this->app->register(EventServiceProvider::class);
        $this->app->register(RouteServiceProvider::class);
    }

    private function publish(): void
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                self::CONFIG_FILE => config_path('api-io-tracker.php'),
            ], 'config');

            $this->publishes([
                __DIR__.'/../database/migrations/' => database_path('migrations'),
            ], 'migrations');

            $this->publishes([
                __DIR__.'/../resources/views' => resource_path('views/vendor/api-io-tracker-views'),
            ], 'views');

            $this->publishes([
                __DIR__.'/../resources/lang' => resource_path('lang/vendor/api-io-tracker'),
            ], 'translations');
        }
    }

    private function registerCommands(): void
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
            ]);
        }
    }

    public function registerMiddleware(Router $router): void
    {
    }

    public function registerListeners(): void
    {
        //        $this->app['events']->listen(TripwireBlockedEvent::class, NotifyAdmin::class);
    }

    public function registerTranslations(): void
    {
        $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'api-io-tracker');
    }
}
