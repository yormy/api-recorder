<?php

namespace Yormy\ApiIoTracker\DTO;

use Illuminate\Http\Client\Request;
use Illuminate\Http\Client\Response;
use Yormy\ApiIoTracker\Services\Resolvers\UserResolver;

class LogData
{
    public static function make(Request $request, ?Response $response, array $data): array
    {
        $headers = self::getHeaders($request, $data);
        $body = self::getBody($request, $data);

        $excludedMessage = config('api-io-tracker.excluded_message');
        if (isset($data['EXCLUDE'])) {
            if (in_array('RESPONSE', $data['EXCLUDE'])) {
                $response = $excludedMessage;
            }
        }

        $data = [
            'url' => $request->url(),
            'method' => $request->method(),
            'headers' => json_encode($headers),
            'body' => substr(json_encode($body), 0, 6000),
            'response' => $response ? substr($response, 0, 6000) : null,
        ];

        $user = UserResolver::getCurrent();
        if ($user) {
            $data['user_id'] = $user->id;
            $data['user_type'] = get_class($user);
        }

        return $data;
    }

    private static function mask(array $data, array $masks): array
    {
        $message = config('api-io-tracker.masked_message');
        foreach ($data as $key => $value) {
            if (in_array(strtoupper($key), $masks)) {
                $data[$key] = $message;
            }
        }

        return $data;
    }

    private static function getBody(Request $request, array $data): array
    {
        $excludedMessage = config('api-io-tracker.excluded_message');
        if (isset($data['EXCLUDE']) && in_array('BODY', $data['EXCLUDE'])) {
            return [$excludedMessage];
        }

        $body = $request->body();
        if (! $body) {
            return [];
        }

        $body = json_decode($body, true);
        $bodyMaskGlobal = static::upperCase(config('api-io-tracker.field_masking.outgoing.body'));
        $bodyMaskUrl = $data['MASK']['BODY'] ?? [];
        $bodyMask = array_merge($bodyMaskGlobal, $bodyMaskUrl);
        if (isset($bodyMask)) {
            $body = static::mask($body, $bodyMask);
        }

        return $body;
    }

    private static function getHeaders(Request $request, array $data): array
    {
        $excludedMessage = config('api-io-tracker.excluded_message');
        if (isset($data['EXCLUDE']) && in_array('HEADERS', $data['EXCLUDE'])) {
            return [$excludedMessage];
        }

        $headers = $request->headers();
        if (! $headers) {
            return [];
        }

        $headersMaskGlobal = static::upperCase(config('api-io-tracker.field_masking.outgoing.headers'));
        $headersMaskUrl = $data['MASK']['HEADERS'] ?? [];
        $headersMask = array_merge($headersMaskGlobal, $headersMaskUrl);
        if (isset($headersMask)) {
            $headers = static::mask($headers, $headersMask);
        }

        return $headers;
    }

    private static function upperCase(array $values): array
    {
        $json = json_encode($values);
        $upper = strtoupper($json);

        return json_decode($upper, true);
    }
}
