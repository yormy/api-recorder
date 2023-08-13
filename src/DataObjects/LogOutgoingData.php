<?php

namespace Yormy\ApiIoTracker\DataObjects;

use Illuminate\Http\Client\Request;
use Illuminate\Http\Client\Response;

class LogOutgoingData extends LogData
{
    public static function make(Request $request, ?Response $response, array $data): array
    {
        $body = $request->body();
        $body = json_decode($body, true);

        $data = parent::makeNow(
            url: $request->url(),
            method: $request->method(),
            statusCode: $response ? $response->status() : 0,
            headers: $request->headers(),
            response: $response,
            body: $body,
            data: $data,
        );

        return $data;
    }

    protected static function getGlobalFilter(): array
    {
        return static::upperCase(config('api-io-tracker.outgoing.mask'));
    }
}
