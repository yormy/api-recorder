<?php

namespace Yormy\ApiIoTracker\Tests\Traits;

use Illuminate\Http\Request;

trait RequestTrait
{
    protected function createRequest(
        $method,
        $content,
        $uri = '/test',
        $server = ['CONTENT_TYPE' => 'application/json'],
        $parameters = [],
        $cookies = [],
        $files = []
    ) {
        $request = new Request;

        return $request->createFromBase(\Symfony\Component\HttpFoundation\Request::create($uri, $method, $parameters, $cookies, $files, $server, $content));
    }
}
