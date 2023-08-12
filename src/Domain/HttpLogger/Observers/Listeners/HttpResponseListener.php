<?php

namespace Yormy\ApiIoTracker\Domain\HttpLogger\Observers\Listeners;

use Yormy\ApiIoTracker\Domain\HttpLogger\Models\LogHttpOutgoing;
use Yormy\ApiIoTracker\DTO\LogData;
use Yormy\ApiIoTracker\DTO\LogOutgoingData;
use Yormy\StringGuard\Services\UrlGuard;

class HttpResponseListener
{
    public function handle(object $event): void
    {
        $url = $event->request->url();
        $method = $event->request->method();
        $config = config('api-io-tracker.url_guards');
        $include = UrlGuard::isIncluded($url, $method, $config);
        $data = UrlGuard::getData($url, $method, $config);

        if (! $include) {
            return;
        }

        $logData = LogOutgoingData::make($event->request, $event?->response, $data);

        LogHttpOutgoing::create([
            'status' => 'OK',
            ...$logData,
        ]);
    }
}
