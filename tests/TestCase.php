<?php

namespace Yormy\ApiIoTracker\Tests;

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
use Yormy\TripwireLaravel\Observers\Events\Blocked\TripwireBlockedEvent;
use Yormy\TripwireLaravel\Observers\Listeners\NotifyAdmin;
use Yormy\TripwireLaravel\Observers\Listeners\Tripwires\LoginFailedWireListener;

abstract class TestCase extends BaseTestCase
{
    // disable after migration to inpect db during test
    //use RefreshDatabase;

    protected function setUp(): void
    {
        $this->updateEnv();

        //$this->setupDatabase();

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
    }

//    protected function setupMiddleware()
//    {
//        $this->app->make('Illuminate\Contracts\Http\Kernel')
//            ->pushMiddleware('Illuminate\Session\Middleware\StartSession')
//            ->pushMiddleware('Illuminate\View\Middleware\ShareErrorsFromSession::class');
//    }

    protected function updateEnv()
    {
//        copy('./tests/Setup/.env', './vendor/orchestra/testbench-core/laravel/.env');
    }

//    protected function setupDatabase()
//    {
//        $migrations = [
//            'audits.php'
//        ];
//        foreach ($migrations as $filename) {
//            copy("./tests/Setup/Database/Migrations/$filename", "./vendor/orchestra/testbench-core/laravel/database/migrations/$filename");
//        }
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
