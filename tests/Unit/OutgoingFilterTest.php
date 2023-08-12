<?php

namespace Yormy\ApiIoTracker\Tests\Unit;

use Illuminate\Support\Facades\Http;
use Yormy\ApiIoTracker\Models\LogHttpOutgoing;
use Yormy\ApiIoTracker\Tests\TestCase;
use Yormy\StringGuard\DataObjects\UrlGuardConfig;

class OutgoingFilterTest extends TestCase
{
    /**
     * @test
     *
     * @group tracker
     */
    public function Outgoing_UrlExcluded_NotLogged(): void
    {
        $countStart = LogHttpOutgoing::count();

        $urlGuard = [
            'include' => [
                UrlGuardConfig::make('*'),
            ],
            'exclude' => [
                UrlGuardConfig::make('https://example-failed*'),
            ],
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
     *
     * @group tracker
     */
    public function Outgoing_UrlNotExcluded_Logged(): void
    {
        $countStart = LogHttpOutgoing::count();

        $urlGuard = [
            'include' => [
                UrlGuardConfig::make('*'),
            ],
            'exclude' => [
            ],
        ];

        config(['api-io-tracker.url_guards' => $urlGuard]);

        try {
            Http::post('https://include_log.nl', ['hello' => 'kkkk']);
        } catch (\Throwable $e) {
        }
        $this->assertGreaterThan($countStart, LogHttpOutgoing::count());
    }


    /**
     * @test
     *
     * @group outgoing-mask
     */
    public function Outgoing_UrlFieldExcluded_Excluded(): void
    {
        LogHttpOutgoing::truncate();

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
        config(['api-io-tracker.url_guards' => $urlGuard]);

        Http::post('https://google.com', ['hello' => 'kkkk']);
        $lastItem = LogHttpOutgoing::latest()->first();

        $message = config('api-io-tracker.excluded_message');

        $this->assertEquals(json_encode([$message]), $lastItem->headers);
        $this->assertEquals(json_encode([$message]), $lastItem->body);
        $this->assertEquals($message, $lastItem->response);
    }


    /**
     * @test
     *
     * @group outgoing-filter
     */
    public function Outgoing_UrlFieldNotExcluded_Included(): void
    {
        LogHttpOutgoing::truncate();

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
        config(['api-io-tracker.url_guards' => $urlGuard]);

        Http::post('https://google.com', ['hello' => 'kkkk']);
        $lastItem = LogHttpOutgoing::latest()->first();

        $message = config('api-io-tracker.excluded_message');

        $this->assertNotEquals(json_encode([$message]), $lastItem->headers);
        $this->assertNotEquals(json_encode([$message]), json_encode($lastItem->body));
        $this->assertNotEquals($message, $lastItem->response);
    }
}
