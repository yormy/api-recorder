<?php

namespace Yormy\ApiRecorder\Observers\Listeners;

use Yormy\ApiRecorder\DataObjects\LogOutgoingData;
use Yormy\ApiRecorder\Models\LogHttpOutgoing;

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
