<?php

namespace Yormy\ApiIoTracker\DataObjects;

use Yormy\ApiIoTracker\Services\Resolvers\UserResolver;

class LogPlainOutgoingData extends LogData
{
    public static function make(
        string $url,
        string $method,
        array $headers,
        string $response,
        array $body,
        array $filter
    ): array {
        return parent::makeNow(
            url: $url,
            method: $method,
            headers: $headers,
            response: $response,
            params: $body,
            data: $filter,
        );
    }

    protected static function getGlobalFilter(): array
    {
        return static::upperCase(config('api-io-tracker.field_masking.outgoing'));
    }
}
