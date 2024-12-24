<?php

namespace Yormy\ApiRecorder\Observers\Listeners;

use Yormy\StringGuard\Services\UrlGuard;

class BaseListener
{
    protected bool $include;

    protected array $data;

    protected function setFilter($event)
    {
        if (! config('api-recorder.enabled') || ! config('api-recorder.outgoing.enabled')) {
            $this->include = false;
            $this->data = [];

            return;
        }

        $url = $event->request->url();
        $method = $event->request->method();
        $config = config('api-recorder.outgoing.url_guards');
        $this->include = UrlGuard::isIncluded($url, $method, $config);
        $this->data = UrlGuard::getData($url, $method, $config);
    }
}
