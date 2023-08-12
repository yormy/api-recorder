<?php

namespace Yormy\ApiIoTracker\DTO;

class LogData
{
    protected static function mask(array $data, array $masks): array
    {
        $message = config('api-io-tracker.masked_message');
        foreach ($data as $key => $value) {
            if (in_array(strtoupper($key), $masks)) {
                $data[$key] = $message;
            }
        }

        return $data;
    }

    protected static function filterBody(?array $body, array $data): array
    {
        $excludedMessage = config('api-io-tracker.excluded_message');
        if (isset($data['EXCLUDE']) && in_array('BODY', $data['EXCLUDE'])) {
            return [$excludedMessage];
        }

        if (empty($body)) {
            return [];
        }

        $bodyMaskGlobal = static::upperCase(config('api-io-tracker.field_masking.outgoing.body'));
        $bodyMaskUrl = $data['MASK']['BODY'] ?? [];
        $bodyMask = array_merge($bodyMaskGlobal, $bodyMaskUrl);
        if (isset($bodyMask)) {
            $body = static::mask($body, $bodyMask);
        }

        return $body;
    }

    protected static function filterHeaders(?array $headers, array $data): array
    {
        $excludedMessage = config('api-io-tracker.excluded_message');
        if (isset($data['EXCLUDE']) && in_array('HEADERS', $data['EXCLUDE'])) {
            return [$excludedMessage];
        }

        if (empty($headers)) {
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

    protected static function upperCase(array $values): array
    {
        $json = json_encode($values);
        $upper = strtoupper($json);

        return json_decode($upper, true);
    }

}
