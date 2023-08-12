<?php

namespace Yormy\ApiIoTracker\Observers\Listeners;

use Yormy\ApiIoTracker\DataObjects\LogOutgoingData;
use Yormy\ApiIoTracker\Models\LogHttpOutgoing;

class HttpConnectionFailedListener extends BaseListener
{
    public function handle(object $event): void
    {
        $this->setFilter($event);

        if (! $this->include) {
            return;
        }

        $logData = LogOutgoingData::make($event->request, null, $this->data);

        LogHttpOutgoing::create([
            'status' => 'FAILED',
            ...$logData,
        ]);
    }
}
