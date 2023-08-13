<?php

namespace Yormy\ApiIoTracker\Tests\Unit;

use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Http;
use Yormy\ApiIoTracker\Models\LogHttpOutgoing;
use Yormy\ApiIoTracker\Tests\TestCase;
use Yormy\StringGuard\DataObjects\UrlGuardConfig;

class HttpLogTest extends TestCase
{
    /**
     * @test
     *
     * @group tracker
     */
    public function Http_LogConnectionError(): void
    {
        $this->expectException(ConnectionException::class);
        Http::post('https://example-failed-url-test-random.nl', ['hello' => 'kkkk']);
        $lastItem = LogHttpOutgoing::orderBy('id', 'desc')->first();
        $this->assertEquals('FAILED', $lastItem->status);
    }

    /**
     * @test
     *
     * @group tracker
     */
    public function Http_ExcludedUrl_NotLogged(): void
    {
        $exclude = 'https://www.nu.nl';

        $urlGuard = [
            'include' => [
                UrlGuardConfig::make('*'),
            ],
            'exclude' => [
                UrlGuardConfig::make('https://www.nu.*'),
            ],
        ];

        config(['api-io-tracker.outgoing.url_guards' => $urlGuard]);

        $startCount = LogHttpOutgoing::count();
        Http::get($exclude);
        $this->assertEquals($startCount, LogHttpOutgoing::count());
    }

    /**
     * @test
     *
     * @group tracker
     */
    public function Http_Url_Logged(): void
    {
        $exclude = 'https://www.nu.nl';

        $startCount = LogHttpOutgoing::count();
        Http::get($exclude);
        $this->assertNotEquals($startCount, LogHttpOutgoing::count());

        $lastItem = LogHttpOutgoing::orderBy('id', 'desc')->first();
        $this->assertEquals('GET', $lastItem->method);
    }
}
