<?php

namespace Yormy\ApiIoTracker\DataObjects;

use Yormy\ApiIoTracker\Services\Resolvers\UserResolver;

class LogPlainOutgoingData extends LogData
{
    public static function make(
        string $url,
        string $method,
        array $headers,
        array $response,
        array $params,
        array $data
    ): array {
        //$headers = $request->headers();
        $headers = self::filterHeaders($headers, $data);

        $body = $params;
        $body = self::filterBody($body, $data);

        $excludedMessage = config('api-io-tracker.excluded_message');
        if (isset($data['EXCLUDE'])) {
            if (in_array('RESPONSE', $data['EXCLUDE'])) {
                $response = $excludedMessage;
            }
        }

        $data = [
            'url' => $url,
            'method' => $method,
            'headers' => substr(json_encode($headers),0, 200),
            'body' => substr(json_encode($body), 0, 200),
            'response' => substr(json_encode($response),0, 600),// ? substr($response, 0, 6000) : null,
        ];

        $user = UserResolver::getCurrent();
        if ($user) {
            $data['user_id'] = $user->id;
            $data['user_type'] = get_class($user);
        }

        return $data;
    }

    protected static function getGlobalFilter(): array
    {
        return static::upperCase(config('api-io-tracker.field_masking.outgoing'));
    }
}
