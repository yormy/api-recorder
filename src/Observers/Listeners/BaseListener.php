<?php

namespace Yormy\ApiIoTracker\Observers\Listeners;

use Yormy\StringGuard\Services\UrlGuard;

class BaseListener
{
    protected bool $include;

    protected array $data;

    protected function setFilter($event)
    {
        if (!config('api-io-tracker.enabled_outgoing')) {
            $this->include = false;
            $this->data = [];
            return;
        }

        $url = $event->request->url();
        $method = $event->request->method();
        $config = config('api-io-tracker.outgoing_url_guards');
        $this->include = UrlGuard::isIncluded($url, $method, $config);
        $this->data = UrlGuard::getData($url, $method, $config);
    }
}
