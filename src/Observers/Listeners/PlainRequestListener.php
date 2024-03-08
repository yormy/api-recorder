<?php

namespace Yormy\ApiRecorder\Observers\Listeners;

use Yormy\ApiRecorder\DataObjects\LogPlainOutgoingData;
use Yormy\ApiRecorder\Models\LogHttpOutgoing;
use Yormy\StringGuard\Services\UrlGuard;

class PlainRequestListener
{
    public function handle(object $event): void
    {
        if (! config('api-recorder.enabled') || !config('api-recorder.outgoing.enabled')) {
            $this->include = false;
            $this->data = [];

            return;
        }

        $url = $event->url;
        $method = $event->method;
        $config = config('api-recorder.outgoing.url_guards');
        $include = UrlGuard::isIncluded($url, $method, $config);
        $data = UrlGuard::getData($url, $method, $config);

        if (! $include) {
            return;
        }

        $logData = LogPlainOutgoingData::make(
            $url,
            $method,
            $event->responseCode,
            $this->convertHeaders($event->headers),
            $event->responseBody,
            $event->body,
            $data
        );

        LogHttpOutgoing::create([
            'status' => 'OK',
            ...$logData,
        ]);
    }

    private function convertHeaders(array $headers): array
    {
        $newHeaders = [];

        $separator = ': ';
        foreach ($headers as $string) {
            $parts = explode($separator, $string);
            $key = $parts[0];

            unset($parts[0]);
            $value = implode($separator, $parts);
            $newHeaders[$key] = $value;
        }

        return $newHeaders;
    }
}
