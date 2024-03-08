<?php

namespace Yormy\ApiRecorder\Tests\Unit;

use Illuminate\Support\Facades\Http;
use Yormy\ApiRecorder\Models\LogHttpOutgoing;
use Yormy\ApiRecorder\Tests\TestCase;
use Yormy\StringGuard\DataObjects\UrlGuardConfig;

class OutgoingMaskTest extends TestCase
{
    /**
     * @test
     *
     * @group masked
     */
    public function Outgoing_MaskFields_Success(): void
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

        config(['api-recorder.outgoing.url_guards' => $urlGuard]);

        Http::post('https://google.com', ['welcome' => 'message', 'hello' => 'kkkk']);
        $lastItem = LogHttpOutgoing::orderBy('id', 'desc')->first();

        $message = config('api-recorder.masked_message');
        $this->assertEquals(json_decode($lastItem->headers, true)['User-Agent'], $message);
        $this->assertEquals(json_decode($lastItem->body, true)['hello'], $message);
    }
}
