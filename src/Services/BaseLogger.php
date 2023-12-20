<?php

namespace Yormy\ApiIoTracker\Services;

use Illuminate\Support\Facades\Event;
use Illuminate\Support\Str;

abstract class BaseLogger
{
    public $modelsRetrieved = [];

    public function __construct()
    {
        $this->listeners();
    }

    protected function listeners()
    {
        try {
            Event::listen('eloquent.*', function ($event, $models) {
                if (Str::contains($event, 'eloquent.retrieved')) {
                    foreach (array_filter($models) as $model) {
                        $class = get_class($model);
                        $this->modelsRetrieved[$class] = ($this->modelsRetrieved[$class] ?? 0) + 1;
                    }
                }
            });
        } catch (\Throwable $e) {
            // ... silent discard message, to handle errors on the clients models
        }
    }
}
