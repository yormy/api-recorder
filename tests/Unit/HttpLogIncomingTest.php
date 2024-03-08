<?php

namespace Yormy\ApiRecorder\Tests\Unit;

use Yormy\ApiRecorder\Models\LogHttpIncoming;
use Yormy\ApiRecorder\Tests\TestCase;
use Yormy\ApiRecorder\Tests\Traits\RequestTrait;

class HttpLogIncomingTest extends TestCase
{
    use RequestTrait;

    /**
     * @test
     *
     * @group incoming
     */
    public function HttpIncoming_Post_Log(): void
    {
        $url = route('test.postroute', []);
        $this->json('POST', $url, ['hello' => 'ewlcome']);

        $lastItem = LogHttpIncoming::latest()->first();
        $this->assertSame($lastItem->status_code, 200);
        $this->assertSame($lastItem->method, 'POST');
        $this->assertSame($lastItem->url, $url);
    }

    /**
     * @test
     *
     * @group incoming
     */
    public function HttpIncoming_Get_Log(): void
    {
        $url = route('test.getroute', []);
        $this->json('GET', $url, ['hello' => 'ewlcome']);

        $lastItem = LogHttpIncoming::latest()->first();
        $this->assertSame($lastItem->status_code, 200);
        $this->assertSame($lastItem->method, 'GET');
        $this->assertSame($lastItem->url, $url);
    }

    private function toRelativeUrl(string $url): string
    {
        $relativeUrl = $url;
        $relativeUrl = str_replace('http://localhost/', '', $relativeUrl);
        $relativeUrl = str_replace('https://localhost/', '', $relativeUrl);

        return $relativeUrl;
    }
}
