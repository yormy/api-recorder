<?php

namespace Yormy\ApiIoTracker\Tests\Unit;

use Yormy\ApiIoTracker\Tests\TestCase;
use Yormy\ApiIoTracker\Tests\Traits\RequestTrait;

class HttpLogIncomingTest extends TestCase
{
    use RequestTrait;

    public function setUp(): void
    {
        define('LARAVEL_START', microtime(true));
        parent::setUp();
    }

    /**
     * @test
     *
     * @group xxx
     */
    public function Http_LogConnectionError(): void
    {
        $url = route('test.getroute', []);
        $this->json('GET', $url);
        dd();

        $url = route('test.postroute', []);
        $this->json('POST', $url, ['hello' =>'ewlcome']);
    }
}
