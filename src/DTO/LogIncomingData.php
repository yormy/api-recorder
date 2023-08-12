<?php

namespace Yormy\ApiIoTracker\DTO;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Route;
use Yormy\ApiIoTracker\Services\Resolvers\IpResolver;
use Yormy\ApiIoTracker\Services\Resolvers\UserResolver;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;

class LogIncomingData extends LogData
{
    public static function make(
        Request $request,
        Response|JsonResponse|RedirectResponse $response,
        array $data,
        array $modelsRetrieved
    ): array {
        [$controller, $action] = static::getCurrentRoute();

        $data = [];
        $data['status_code'] = $response->status();
        $data['url'] = $request->path();
        $data['method'] = $request->method();

        $user = UserResolver::getCurrent();
        if ($user) {
            $data['user_id'] = $user->id;
            $data['user_type'] = get_class($user);
        }

        $headers = $request->headers->all();
        $headers = self::filterHeaders($headers, []);
        $data['headers'] = json_encode($headers);

        $body = $request->all();
        $data['body'] = self::filterBody($body, []);

        $data['body_raw'] = config('api-io-tracker.body_raw', false) ? file_get_contents('php://input') : null;

        $data['response'] = $response->getContent();
        $data['response_headers'] = 'todo response headers'; //$this->headers($response);
        $data['duration'] = static::getDuration();
        $data['controller'] = $controller;
        $data['action'] = $action;
        $data['models_retrieved'] = $modelsRetrieved;
        $data['from_ip'] = IpResolver::get($request);

        return $data;
    }

    private static function getDuration(): float
    {
        return number_format(microtime(true) - LARAVEL_START, 3);
    }

    private static function getCurrentRoute(): array
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
}
