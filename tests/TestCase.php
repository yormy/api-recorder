<?php

namespace Yormy\ApiIoTracker\Tests;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Route;
use Lab404\Impersonate\ImpersonateServiceProvider;
use Yormy\ApiIoTracker\ApiIoTrackerServiceProvider;
use Yormy\ApiIoTracker\Domain\User\Models\Admin;
use Yormy\ApiIoTracker\Domain\User\Models\Member;
use Yormy\ApiIoTracker\ServiceProviders\EventServiceProvider;
use Orchestra\Testbench\TestCase as BaseTestCase;
use OwenIt\Auditing\AuditingServiceProvider;
use PragmaRX\Google2FALaravel\ServiceProvider as PragmaRxServiceProvider;
use Spatie\LaravelRay\RayServiceProvider;
use Yormy\StringGuard\DataObjects\UrlGuardConfig;
use Yormy\TripwireLaravel\Observers\Events\Blocked\TripwireBlockedEvent;
use Yormy\TripwireLaravel\Observers\Listeners\NotifyAdmin;
use Yormy\TripwireLaravel\Observers\Listeners\Tripwires\LoginFailedWireListener;

abstract class TestCase extends BaseTestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->setUpConfig();

        $this->withoutExceptionHandling();

      //  $this->setupMiddleware();

        $this->app->register(EventServiceProvider::class);
    }

    protected function getPackageProviders($app)
    {
        return [
            ApiIoTrackerServiceProvider::class,
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
            ]
        ];

        config(['api-io-tracker.url_guards' => $urlGuard]);
    }

//    protected function setupMiddleware()
//    {
//        $this->app->make('Illuminate\Contracts\Http\Kernel')
//            ->pushMiddleware('Illuminate\Session\Middleware\StartSession')
//            ->pushMiddleware('Illuminate\View\Middleware\ShareErrorsFromSession::class');
//    }


    /**
     * @psalm-return \Closure():'next'
     */
    public function getNextClosure(): \Closure
    {
        return function () {
            return 'next';
        };
    }
}
