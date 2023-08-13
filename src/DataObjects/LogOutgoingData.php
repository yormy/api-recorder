<?php

namespace Yormy\ApiIoTracker\DataObjects;

use Illuminate\Http\Client\Request;
use Illuminate\Http\Client\Response;
use Yormy\ApiIoTracker\Services\Resolvers\UserResolver;

class LogOutgoingData extends LogData
{
    public static function make(Request $request, ?Response $response, array $data): array
    {
        $headers = $request->headers();
        $headers = self::filterHeaders($headers, $data);

        $body = $request->body();
        $body = json_decode($body, true);
        $body = self::filterBody($body, $data);

        $statusCode = $response ? $response->status() : 0;

        $excludedMessage = config('api-io-tracker.excluded_message');
        if (isset($data['EXCLUDE'])) {
            if (in_array('RESPONSE', $data['EXCLUDE'])) {
                $response = $excludedMessage;
            }
        }

        $data = [
            'status_code' => $statusCode,
            'url' => $request->url(),
            'method' => $request->method(),
            'headers' => json_encode($headers),
            'body' => $body,
            'response' => $response ? substr($response, 0, 6000) : null,
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
