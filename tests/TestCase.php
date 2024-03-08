<?php

namespace Yormy\ApiRecorder\Tests;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;
use Orchestra\Testbench\TestCase as BaseTestCase;
use Yormy\ApiRecorder\ApiRecorderServiceProvider;
use Yormy\ApiRecorder\Http\Middleware\LogIncomingRequest;
use Yormy\ApiRecorder\ServiceProviders\EventServiceProvider;
use Yormy\ApiRecorder\Tests\Setup\Http\Controllers\TestController;
use Yormy\StringGuard\DataObjects\UrlGuardConfig;

abstract class TestCase extends BaseTestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->setUpConfig();

        $this->setupRoutes();

        $this->withoutExceptionHandling();

        $this->app->register(EventServiceProvider::class);
    }

    protected function getPackageProviders($app)
    {
        return [
            ApiRecorderServiceProvider::class,
        ];
    }

    protected function setUpConfig(): void
    {
        config(['app.key' => 'base64:yNmpwO5YE6xwBz0enheYLBDslnbslodDqK1u+oE5CEE=']);

        $urlGuard = [
            'include' => [
                UrlGuardConfig::make('*'),
            ],
            'exclude' => [
            ],
        ];

        config(['api-recorder.outgoing.url_guards' => $urlGuard]);

        if (! defined('LARAVEL_START')) {
            define('LARAVEL_START', microtime(true));
        }
    }

    protected function setupRoutes()
    {
        Log::debug('log setupRoutes');
        Route::prefix('test')
            ->name('test.')
            ->middleware(LogIncomingRequest::class)
            ->group(function () {
                Route::get('/getroute', [TestController::class, 'getRoute'])->name('getroute');
                Route::post('/postroute', [TestController::class, 'postRoute'])->name('postroute');
            });
    }
}
