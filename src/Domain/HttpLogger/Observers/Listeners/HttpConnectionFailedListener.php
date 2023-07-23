<?php

namespace Yormy\ApiIoTracker\Domain\HttpLogger\Observers\Listeners;

use Yormy\ApiIoTracker\Domain\HttpLogger\Models\LogHttpOutgoing;
use Yormy\ApiIoTracker\Domain\HttpLogger\Services\UrlOnlyExcept;

class HttpConnectionFailedListener
{
    public function handle(object $event): void
    {
        $include = UrlOnlyExcept::shouldIncludeREquest($event->request, config('api-io-tracker.httplogger'));

        if (!$include) {
            return;
        }

        LogHttpOutgoing::create([
            'status' => 'FAILED',
            'url' => $event->request->url(),
            'method' => $event->request->method(),
            'headers' => $event->request->headers(),
            'body' => $event->request->body(),
        ]);

    }
}
