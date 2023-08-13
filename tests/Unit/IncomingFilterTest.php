<?php

namespace Yormy\ApiIoTracker\Tests\Unit;

use Yormy\ApiIoTracker\Models\LogHttpIncoming;
use Yormy\ApiIoTracker\Tests\TestCase;
use Yormy\StringGuard\DataObjects\UrlGuardConfig;

class IncomingFilterTest extends TestCase
{
    /**
     * @test
     *
     * @group xxx
     */
    public function Incoming_Disabled_NotLogged(): void
    {
        $countStart = LogHttpIncoming::count();

        $urlGuard = [
            'include' => [
                UrlGuardConfig::make('*'),
            ],
            'exclude' => [
            ],
        ];

        config(['api-io-tracker.incoming.enabled' => false]);
        config(['api-io-tracker.incoming.url_guards' => $urlGuard]);

        $url = route('test.postroute');
        $this->json('POST', $url);

        $this->assertSame($countStart, LogHttpIncoming::count());
    }

    /**
     * @test
     *
     * @group incoming
     */
    public function Incoming_UrlExcluded_NotLogged(): void
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

        config(['api-io-tracker.incoming.url_guards' => $urlGuard]);

        $url = route('test.postroute');
        $this->json('POST', $url);

        $this->assertSame($countStart, LogHttpIncoming::count());
    }

    /**
     * @test
     *
     * @group incoming
     */
    public function Incoming_UrlNotExcluded_Logged(): void
    {
        $countStart = LogHttpIncoming::count();

        $urlGuard = [
            'include' => [
                UrlGuardConfig::make('*'),
            ],
            'exclude' => [
            ],
        ];

        config(['api-io-tracker.incoming.url_guards' => $urlGuard]);

        $url = route('test.postroute');
        $this->json('POST', $url);

        $this->assertGreaterThan($countStart, LogHttpIncoming::count());
    }

    /**
     * @test
     *
     * @group incoming-filter
     */
    public function Incoming_UrlFieldExcluded_Excluded(): void
    {
        $data = [
            'exclude' => [
                'headers',
                'body',
                'response',
            ],
        ];

        $urlGuard = [
            'include' => [
                UrlGuardConfig::make('*', ['*'], $data),
            ],
            'exclude' => [
            ],
        ];
        config(['api-io-tracker.incoming.url_guards' => $urlGuard]);

        $url = route('test.getroute', []);
        $this->json('GET', $url, ['hello' => 'welcome']);
        $lastItem = LogHttpIncoming::orderBy('id', 'desc')->first();

        $message = config('api-io-tracker.excluded_message');

        $this->assertEquals($message, $lastItem->headers);
        $this->assertEquals($message, $lastItem->body);
        $this->assertEquals($message, $lastItem->response);
    }

    /**
     * @test
     *
     * @group incoming-filter
     */
    public function Incoming_UrlFieldNotExcluded_Included(): void
    {
        $data = [
            'exclude' => [],
        ];

        $urlGuard = [
            'include' => [
                UrlGuardConfig::make('*', ['*'], $data),
            ],
            'exclude' => [
            ],
        ];
        config(['api-io-tracker.incoming.url_guards' => $urlGuard]);

        $url = route('test.getroute', []);
        $this->json('GET', $url, ['hello' => 'welcome']);
        $lastItem = LogHttpIncoming::orderBy('id', 'desc')->first();

        $message = config('api-io-tracker.excluded_message');

        $this->assertNotEquals(json_encode([$message]), $lastItem->headers);
        $this->assertNotEquals(json_encode([$message]), json_encode($lastItem->body));
        $this->assertNotEquals($message, $lastItem->response);
    }
}
