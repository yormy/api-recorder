<?php

namespace Yormy\ApiIoTracker\Domain\HttpLogger\Observers;

use Illuminate\Events\Dispatcher;
use Illuminate\Http\Client\Events\ConnectionFailed;
use Illuminate\Http\Client\Events\RequestSending;
use Illuminate\Http\Client\Events\ResponseReceived;
use Yormy\ApiIoTracker\Domain\HttpLogger\Observers\Listeners\HttpConnectionFailedListener;
use Yormy\ApiIoTracker\Domain\HttpLogger\Observers\Listeners\HttpRequestListener;
use Yormy\ApiIoTracker\Domain\HttpLogger\Observers\Listeners\HttpResponseListener;

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
    }
}
