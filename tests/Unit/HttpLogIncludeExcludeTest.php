<?php

namespace Yormy\ApiIoTracker\Tests\Unit;

use GuzzleLogMiddleware\LogMiddleware;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Http;
use Yormy\ApiIoTracker\Domain\HttpLogger\Models\LogHttpOutgoing;
use Yormy\ApiIoTracker\Services\SimpleHandler;
use Yormy\ApiIoTracker\Tests\TestCase;
use Yormy\StringGuard\DataObjects\UrlGuardConfig;

class HttpLogIncludeExcludeTest extends TestCase
{
    /**
     * @test
     * @group tracker
     */
    public function HttpError_Excluded_NotLogged(): void
    {
        $countStart = LogHttpOutgoing::count();

        $urlGuard = [
            'include' => [
                UrlGuardConfig::make('*'),
            ],
            'exclude' => [
                UrlGuardConfig::make('https://example-failed*'),
            ]
        ];

        config(['api-io-tracker.url_guards' => $urlGuard]);

        try {
            Http::post('https://example-failed-url-test-random.nl', ['hello' => 'kkkk']);
        } catch (\Throwable $e) {
            $this->assertSame($countStart, LogHttpOutgoing::count());
        }
    }

    /**
     * @test
     * @group tracker
     */
    public function HttpError_Included_Logged(): void
    {
        $countStart = LogHttpOutgoing::count();

        $urlGuard = [
            'include' => [
                UrlGuardConfig::make('*'),
            ],
            'exclude' => [
            ]
        ];

        config(['api-io-tracker.url_guards' => $urlGuard]);

        try {
            Http::post('https://include_log.nl', ['hello' => 'kkkk']);
        } catch (\Throwable $e) {
        }
        $this->assertGreaterThan($countStart, LogHttpOutgoing::count());
    }
}
