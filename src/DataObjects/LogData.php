<?php

namespace Yormy\ApiIoTracker\DataObjects;

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

    protected static function filterResponse(?string $response, array $filter): string
    {
        $excludedMessage = config('api-io-tracker.excluded_message');
        if (isset($filter['EXCLUDE']) && in_array('RESPONSE', $filter['EXCLUDE'])) {
            return $excludedMessage;
        }

        if (empty($response)) {
            return '';
        }

        return substr($response, 0, config('api-io-tracker.max_response_size'));
    }

    protected static function filterBody(?array $body, array $filter): string
    {
        $excludedMessage = config('api-io-tracker.excluded_message');
        if (isset($filter['EXCLUDE']) && in_array('BODY', $filter['EXCLUDE'])) {
            return $excludedMessage;
        }

        if (empty($body)) {
            return '';
        }

        $bodyMaskGlobal = static::getGlobalFilter()['BODY'];
        $bodyMaskUrl = $filter['MASK']['BODY'] ?? [];
        $bodyMask = array_merge($bodyMaskGlobal, $bodyMaskUrl);
        if (isset($bodyMask)) {
            $body = static::mask($body, $bodyMask);
        }

        return substr(json_encode($body), 0, config('api-io-tracker.max_body_size'));
    }

    protected static function filterHeaders(?array $headers, array $filter): string
    {
        $excludedMessage = config('api-io-tracker.excluded_message');
        if (isset($filter['EXCLUDE']) && in_array('HEADERS', $filter['EXCLUDE'])) {
            return $excludedMessage;
        }

        if (empty($headers)) {
            return '';
        }

        $headersMaskGlobal = static::getGlobalFilter()['HEADERS'];
        $headersMaskUrl = $filter['MASK']['HEADERS'] ?? [];
        $headersMask = array_merge($headersMaskGlobal, $headersMaskUrl);
        if (isset($headersMask)) {
            $headers = static::mask($headers, $headersMask);
        }

        return substr(json_encode($headers), 0, config('api-io-tracker.max_header_size'));
    }

    protected static function upperCase(array $values): array
    {
        $json = json_encode($values);
        $upper = strtoupper($json);

        return json_decode($upper, true);
    }
}
