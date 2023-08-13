<?php

namespace Yormy\ApiIoTracker\Observers\Listeners;

use Yormy\ApiIoTracker\DataObjects\LogPlainOutgoingData;
use Yormy\ApiIoTracker\Models\LogHttpOutgoing;
use Yormy\StringGuard\Services\UrlGuard;

class PlainRequestListener
{
    public function handle(object $event): void
    {
        if (! config('api-io-tracker.enabled_outgoing')) {
            $this->include = false;
            $this->data = [];

            return;
        }

        $url = $event->url;
        $method = $event->method;
        $config = config('api-io-tracker.outgoing_url_guards');
        $include = UrlGuard::isIncluded($url, $method, $config);
        $data = UrlGuard::getData($url, $method, $config);

        if (! $include) {
            return;
        }

        $logData = LogPlainOutgoingData::make(
            $url,
            $method,
            $event->responseCode,
            $event->headers,
            $event->responseBody,
            $event->body,
            $data
        );

        LogHttpOutgoing::create([
            'status' => 'OK',
            ...$logData,
        ]);
    }
}
