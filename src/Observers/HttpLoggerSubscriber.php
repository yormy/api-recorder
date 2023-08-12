<?php

namespace Yormy\ApiIoTracker\Observers;

use Illuminate\Events\Dispatcher;
use Illuminate\Http\Client\Events\ConnectionFailed;
use Illuminate\Http\Client\Events\RequestSending;
use Illuminate\Http\Client\Events\ResponseReceived;
use Yormy\ApiIoTracker\Observers\Events\PlainRequestEvent;
use Yormy\ApiIoTracker\Observers\Listeners\HttpConnectionFailedListener;
use Yormy\ApiIoTracker\Observers\Listeners\HttpRequestListener;
use Yormy\ApiIoTracker\Observers\Listeners\HttpResponseListener;
use Yormy\ApiIoTracker\Observers\Listeners\PlainRequestListener;

class HttpLoggerSubscriber
{
    public function subscribe(Dispatcher $events): void
    {
        $events->listen(
            RequestSending::class,
            HttpRequestListener::class
        );

        $events->listen(
            ResponseReceived::class,
            HttpResponseListener::class
        );

        $events->listen(
            ConnectionFailed::class,
            HttpConnectionFailedListener::class
        );

        $events->listen(
            PlainRequestEvent::class,
            PlainRequestListener::class
        );
    }
}
