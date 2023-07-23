<?php

namespace Yormy\ApiIoTracker\Domain\HttpLogger\Observers\Listeners;

use Yormy\ApiIoTracker\Domain\HttpLogger\Services\UrlOnlyExcept;

class HttpRequestListener
{
    public function handle(object $event): void
    {
        $include = UrlOnlyExcept::shouldIncludeREquest($event->request, config('api-io-tracker.httplogger'));

        if (!$include) {
            return;
        }
    }
}
