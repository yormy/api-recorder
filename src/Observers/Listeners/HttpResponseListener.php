<?php

namespace Yormy\ApiRecorder\Observers\Listeners;

use Yormy\ApiRecorder\DataObjects\LogOutgoingData;
use Yormy\ApiRecorder\Models\LogHttpOutgoing;

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
