<?php

namespace Yormy\ApiIoTracker\Observers\Listeners;

class HttpRequestListener extends BaseListener
{
    public function handle(object $event): void
    {
        $this->setFilter($event);

        if (! $this->include) {
            return;
        }
    }
}
