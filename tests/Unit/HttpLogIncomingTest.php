<?php

namespace Yormy\ApiIoTracker\Tests\Unit;

use Yormy\ApiIoTracker\Domain\HttpLogger\Models\LogHttpIncoming;
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
        LogHttpIncoming::truncate();

        $url = route('test.postroute', []);
        $this->json('POST', $url, ['hello' =>'ewlcome']);

        $lastItem = LogHttpIncoming::latest()->first();
        $this->assertSame($lastItem->status_code, 200);
        $this->assertSame($lastItem->method, 'POST');

        $relativeUrl = $lastItem->url;
        $relativeUrl = str_replace('http://localhost/', '', $relativeUrl);
        $relativeUrl = str_replace('https://localhost/', '', $relativeUrl);
        $this->assertSame($lastItem->url, $relativeUrl);
    }


    /**
     * @test
     *
     * @group incoming
     */
    public function HttpIncoming_Get_Log(): void
    {
        LogHttpIncoming::truncate();

        $url = route('test.getroute', []);
        $this->json('GET', $url, ['hello' =>'ewlcome']);

        $lastItem = LogHttpIncoming::latest()->first();
        $this->assertSame($lastItem->status_code, 200);
        $this->assertSame($lastItem->method, 'GET');

        $relativeUrl = $lastItem->url;
        $relativeUrl = str_replace('http://localhost/', '', $relativeUrl);
        $relativeUrl = str_replace('https://localhost/', '', $relativeUrl);
        $this->assertSame($lastItem->url, $relativeUrl);
    }

}
