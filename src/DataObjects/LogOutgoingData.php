<?php

namespace Yormy\ApiIoTracker\DataObjects;

use Illuminate\Http\Client\Request;
use Illuminate\Http\Client\Response;
use Yormy\ApiIoTracker\Services\Resolvers\UserResolver;

class LogOutgoingData extends LogData
{
    public static function make(Request $request, ?Response $response, array $data): array
    {
        $body = $request->body();
        $body = json_decode($body, true);

        $data = parent::makeNow(
            url: $request->url(),
            method: $request->method(),
            headers: $request->headers(),
            response: $response,
            params: $body,
            data: $data,
        );

        $statusCode = $response ? $response->status() : 0;

        $data['status_code'] = $statusCode;

        return $data;
    }

    protected static function getGlobalFilter(): array
    {
        return static::upperCase(config('api-io-tracker.field_masking.outgoing'));
    }
}
