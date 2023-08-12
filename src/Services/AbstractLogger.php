<?php

namespace Yormy\ApiIoTracker\Services;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;
use Psy\Util\Json;
use Yormy\ApiIoTracker\Services\Resolvers\IpResolver;
use Yormy\ApiIoTracker\Services\Resolvers\UserResolver;

abstract class AbstractLogger
{
    protected $logs = [];

    public $modelsRetrieved = [];

    public function __construct()
    {
        $this->listeners();
    }

    protected function listeners()
    {
        Event::listen('eloquent.*', function ($event, $models) {
            if (Str::contains($event, 'eloquent.retrieved')) {
                foreach (array_filter($models) as $model) {
                    $class = get_class($model);
                    $this->modelsRetrieved[$class] = ($this->modelsRetrieved[$class] ?? 0) + 1;
                }
            }
        });
    }

    public function logData(Request $request, Response|JsonResponse|RedirectResponse $response)
    {
        [$controller, $action] = $this->getCurrentRoute();

        $data = [];
        $data['status_code'] = $response->status();
        $data['url'] = $request->path();
        $data['method'] = $request->method();

        $user = UserResolver::getCurrent();
        if ($user) {
            $data['user_id'] = $user->id;
            $data['user_type'] = get_class($user);
        }

        $data['headers'] = $this->headers($request);
        $data['body'] = $this->payload($request);

        $data['body_raw'] = config('api-io-tracker.body_raw', false) ? file_get_contents('php://input') : null;

        $data['response'] = $response->getContent();
        $data['response_headers'] = $this->headers($response);
        $data['duration'] = $this->getDuration();
        $data['controller'] = $controller;
        $data['action'] = $action;
        $data['models_retrieved'] = $this->modelsRetrieved;
        $data['from_ip'] = IpResolver::get($request);

        return $data;
    }

    private function getDuration(): float
    {
        return number_format(microtime(true) - LARAVEL_START, 3);
    }

    private function getCurrentRoute(): array
    {
        $controller = '';
        $action = '';
        $currentRouteAction = Route::currentRouteAction();
        if ($currentRouteAction) {
            if (strpos($currentRouteAction, '@') !== false) {
                [$controller, $action] = explode('@', $currentRouteAction);
            } else {
                // If we get a string, just use that.
                if (is_string($currentRouteAction)) {
                    [$controller, $action] = ['', $currentRouteAction];
                } else {
                    // Otherwise force it to be some type of string using `json_encode`.
                    [$controller, $action] = ['', (string) json_encode($currentRouteAction)];
                }
            }
        }

        return [$controller, $action];
    }



    /**
     * Formats the request payload for logging
     *
     * @return string
     */
    protected function payload($request)
    {
        $allFields = $request->all();

        foreach (config('apilog.dont_log', []) as $key) {
            if (array_key_exists($key, $allFields)) {
                unset($allFields[$key]);
            }
        }

        return json_encode($allFields);
    }

    /**
     * Formats the headers payload for logging
     *
     * @return string
     */
    protected function headers($request)
    {
        $allHeaders = $request->headers->all();

        foreach (config('apilog.dont_log_headers', []) as $key) {
            if (array_key_exists($key, $allHeaders)) {
                unset($allHeaders[$key]);
            }
        }

        return json_encode($allHeaders);
    }
}
