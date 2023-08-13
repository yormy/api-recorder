<?php

namespace Yormy\ApiIoTracker\Tests\Unit;

use Yormy\ApiIoTracker\Models\LogHttpIncoming;
use Yormy\ApiIoTracker\Tests\TestCase;
use Yormy\ApiIoTracker\Tests\Traits\RequestTrait;

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
