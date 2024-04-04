<?php

namespace Yormy\ApiRecorder;

use Illuminate\Routing\Router;
use Illuminate\Support\ServiceProvider;
use Yormy\ApiRecorder\Http\Middleware\LogIncomingRequest;
use Yormy\ApiRecorder\ServiceProviders\EventServiceProvider;
use Yormy\ApiRecorder\ServiceProviders\RouteServiceProvider;
use Yormy\ApiRecorder\Services\Clients\StripeCurlClient;

class ApiRecorderServiceProvider extends ServiceProvider
{
    const CONFIG_FILE = __DIR__.'/../config/api-recorder.php';

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

        $this->loadViewsFrom(__DIR__.'/../resources/views', 'api-recorder');

        $this->registerTranslations();

        // need to use a singleton, otherwise at the terminate of the middleware
        // a new instance is created and the models are lost
        $this->app->singleton(LogIncomingRequest::class);

        if (config('api-recorder.stripe.enabled', false)) {
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
        $this->mergeConfigFrom(static::CONFIG_FILE, 'api-recorder');
        $this->mergeConfigFrom(static::CONFIG_IDE_HELPER_FILE, 'ide-helper');

        $this->app->register(EventServiceProvider::class);
        $this->app->register(RouteServiceProvider::class);
    }

    private function publish(): void
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                self::CONFIG_FILE => config_path('api-recorder.php'),
            ], 'config');

            $this->publishes([
                __DIR__.'/../database/migrations/' => database_path('migrations'),
            ], 'migrations');

            $this->publishes([
                __DIR__.'/../resources/views' => resource_path('views/vendor/api-recorder-views'),
            ], 'views');

            $this->publishes([
                __DIR__.'/../resources/lang' => resource_path('lang/vendor/api-recorder'),
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
        $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'api-recorder');
    }
}
