<?php

namespace Yormy\ApiIoTracker\Tests\Unit;

use GuzzleLogMiddleware\LogMiddleware;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Http;
use Yormy\ApiIoTracker\Domain\HttpLogger\Models\LogHttpOutgoing;
use Yormy\ApiIoTracker\Services\SimpleHandler;
use Yormy\ApiIoTracker\Tests\TestCase;
use Yormy\StringGuard\DataObjects\UrlGuardConfig;

class HttpLogMaskTest extends TestCase
{
    /**
     * @test
     * @group masked
     */
    public function HttpLog_ExcludeLogFields_Succcess(): void
    {
        $data = [
            'exclude' => [
                'headers',
                'body',
                'response',
            ]
        ];

        $urlGuard = [
            'include' => [
                UrlGuardConfig::make('*', ['*'], $data),
            ],
            'exclude' => [
            ]
        ];

        config(['api-io-tracker.url_guards' => $urlGuard]);

        Http::get('https://nu.nl', ['hello' => 'kkkk']);
        $lastItem = LogHttpOutgoing::orderBy('id', 'desc')->first();

        $excludedMessage = config('api-io-tracker.excluded_message');
        $this->assertEquals($lastItem->headers, json_encode([$excludedMessage]));
        $this->assertEquals($lastItem->body, json_encode([$excludedMessage]));
        $this->assertEquals($lastItem->response, $excludedMessage);
    }

    /**
     * @test
     * @group masked
     */
    public function HttpLog_MaskFields_Success(): void
    {
        $data = [
            'mask' => [
                'headers' => ['user-agent'],
                'body' => ['hello'],
            ],
        ];

        $urlGuard = [
            'include' => [
                UrlGuardConfig::make('*', ['*'], $data),
            ],
            'exclude' => [
            ]
        ];

        config(['api-io-tracker.url_guards' => $urlGuard]);

        Http::post('https://google.com', ['welcome' => 'message', 'hello' => 'kkkk']);
        $lastItem = LogHttpOutgoing::orderBy('id', 'desc')->first();

        $message = config('api-io-tracker.masked_message');
        $this->assertEquals(json_decode($lastItem->headers, true)['User-Agent'], $message);
        $this->assertEquals(json_decode($lastItem->body, true)['hello'], $message);
    }

}
