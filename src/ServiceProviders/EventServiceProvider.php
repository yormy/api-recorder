<?php

namespace Yormy\ApiIoTracker\ServiceProviders;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Yormy\ApiIoTracker\Domain\HttpLogger\Observers\HttpLoggerSubscriber;

class EventServiceProvider extends ServiceProvider
{
    protected $subscribe = [
        HttpLoggerSubscriber::class,
    ];
}
