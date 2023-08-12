<?php

namespace Yormy\ApiIoTracker\Observers\Listeners;

use Yormy\ApiIoTracker\DataObjects\LogOutgoingData;
use Yormy\ApiIoTracker\Models\LogHttpOutgoing;

class HttpResponseListener extends BaseListener
{
    public function handle(object $event): void
    {
        $this->setFilter($event);

        if (! $this->include) {
            return;
        }

        $logData = LogOutgoingData::make($event->request, $event?->response, $this->data);

        LogHttpOutgoing::create([
            'status' => 'OK',
            ...$logData,
        ]);
    }
}
