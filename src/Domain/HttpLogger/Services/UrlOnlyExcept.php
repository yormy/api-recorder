<?php

namespace Yormy\ApiIoTracker\Domain\HttpLogger\Services;

use Illuminate\Http\Client\Request;

class UrlOnlyExcept
{
    public static function shouldIncludeRequest(Request $request, array $config): bool
    {
        return self::shouldInclude($request->url(), $request->method(), $config);
    }

    public static function shouldInclude(string $url, string $method, array $config): bool
    {
        $except = self::upperArray($config['except']);
        $only = self::upperArray($config['only']);
        $url = strtoupper($url);

        if (in_array($url, array_keys($except)) && self::hasMethod($method, $except[$url])) {
            return false;
        }

        if (in_array($url, array_keys($only)) && self::hasMethod($method, $only[$url]) ) {
            return true;
        }


        return true;
    }

    private static function upperArray(array $values): array
    {
        $json = json_encode($values);
        $upper = strtoupper($json);

        return json_decode($upper, true);
    }

    public static function hasMethod(string $method, array $values)
    {
        $upper = self::upperArray($values);

        if (in_array('*', $upper) || in_array('ALL', $upper)) {
            return true;
        }

        if (in_array(strtoupper($method), $upper)) {
            return true;
        }

        return false;

    }
}

