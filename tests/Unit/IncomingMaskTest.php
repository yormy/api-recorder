<?php

namespace Yormy\ApiIoTracker\Tests\Unit;

use Yormy\ApiIoTracker\Models\LogHttpIncoming;
use Yormy\ApiIoTracker\Tests\TestCase;
use Yormy\StringGuard\DataObjects\UrlGuardConfig;

class IncomingMaskTest extends TestCase
{
    /**
     * @test
     *
     * @group incoming-mask
     */
    public function Incoming_MaskFields_Success(): void
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
            ],
        ];

        config(['api-io-tracker.incoming_url_guards' => $urlGuard]);

        $url = route('test.postroute');
        $this->json('POST', $url, ['hello' => 'kkk']);

        $lastItem = LogHttpIncoming::orderBy('id', 'desc')->first();

        $message = config('api-io-tracker.masked_message');
        $this->assertEquals(json_decode($lastItem->headers, true)['user-agent'], $message);
        $this->assertEquals($lastItem->body['hello'], $message);
    }
}
