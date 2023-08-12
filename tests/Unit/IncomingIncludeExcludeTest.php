<?php

namespace Yormy\ApiIoTracker\Tests\Unit;

use Illuminate\Support\Facades\Http;
use Yormy\ApiIoTracker\Domain\HttpLogger\Models\LogHttpIncoming;
use Yormy\ApiIoTracker\Domain\HttpLogger\Models\LogHttpOutgoing;
use Yormy\ApiIoTracker\Tests\TestCase;
use Yormy\StringGuard\DataObjects\UrlGuardConfig;

class IncomingIncludeExcludeTest extends TestCase
{
    /**
     * @test
     *
     * @group xxx
     */
    public function Incoming_Excluded_NotLogged(): void
    {
        $countStart = LogHttpIncoming::count();

        $urlGuard = [
            'include' => [
                UrlGuardConfig::make('*'),
            ],
            'exclude' => [
                UrlGuardConfig::make('https://localhost*'),
                UrlGuardConfig::make('http://localhost*'),
            ],
        ];

        config(['api-io-tracker.incoming_url_guards' => $urlGuard]);

        $url = route('test.postroute');
        $this->json('POST', $url);

        $this->assertSame($countStart, LogHttpIncoming::count());
    }

    /**
     * @test
     *
     * @group xxx
     */
    public function Incoming_NotExcluded_Logged(): void
    {
        $countStart = LogHttpIncoming::count();

        $urlGuard = [
            'include' => [
                UrlGuardConfig::make('*'),
            ],
            'exclude' => [
            ],
        ];

        config(['api-io-tracker.incoming_url_guards' => $urlGuard]);

        $url = route('test.postroute');
        $this->json('POST', $url);

        $this->assertGreaterThan($countStart, LogHttpIncoming::count());
    }
}
