<?php

namespace Yormy\ApiIoTracker\Tests\Unit;

use GuzzleLogMiddleware\LogMiddleware;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Http;
use Yormy\ApiIoTracker\Domain\HttpLogger\Models\LogHttpOutgoing;
use Yormy\ApiIoTracker\Services\SimpleHandler;
use Yormy\ApiIoTracker\Tests\TestCase;

class HttpLogTest extends TestCase
{
    /**
     * @test
     * @group xx
     */
    public function Http_LogConnectionError(): void
    {
        $this->expectException(ConnectionException::class);
        Http::post('https://sdfsdfsdfsdfdsu.nl', ['hello' => 'kkkk']);
        $lastItem = LogHttpOutgoing::orderBy('id','desc')->first();
        $this->assertEquals('FAILED', $lastItem->status);
    }

    /**
     * @test
     * @group xx
     */
    public function Http_ExcludedUrl_NotLogged(): void
    {
        $exclude = 'https://www.nu.nl';

        config(['api-io-tracker.httplogger.except' => [
            $exclude => ['*']
        ]]);

        $startCount = LogHttpOutgoing::count();
        Http::get($exclude);
        $this->assertEquals($startCount, LogHttpOutgoing::count());
    }

    /**
     * @test
     * @group xx
     */
    public function Http_Url_Logged(): void
    {
        $exclude = 'https://www.nu.nl';

        config(['api-io-tracker.httplogger.only' => [] ]);
        config(['api-io-tracker.httplogger.except' => [] ]);

        $startCount = LogHttpOutgoing::count();
        Http::get($exclude);
        $this->assertNotEquals($startCount, LogHttpOutgoing::count());

        $lastItem = LogHttpOutgoing::orderBy('id','desc')->first();
        $this->assertEquals('GET', $lastItem->method);
    }
}
