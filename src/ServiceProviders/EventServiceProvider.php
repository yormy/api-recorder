<?php

namespace Yormy\ApiRecorder\ServiceProviders;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Yormy\ApiRecorder\Observers\HttpLoggerSubscriber;

class EventServiceProvider extends ServiceProvider
{
    protected $subscribe = [
        HttpLoggerSubscriber::class,
    ];
}
