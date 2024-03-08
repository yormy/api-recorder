<?php

namespace Yormy\ApiRecorder\DataObjects;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Route;
use Yormy\ApiRecorder\Services\Resolvers\IpResolver;

class LogIncomingData extends LogData
{
    public static function make(
        Request $request,
        Response|JsonResponse|RedirectResponse $response,
        array $filter,
        array $modelsRetrieved
    ): array {

        $data = parent::makeNow(
            url: $request->url(),
            method: $request->method(),
            statusCode: $response->status(),
            headers: $request->headers->all(),
            response: $response,
            body: $request->all(),
            data: $filter,
        );

        $data['body_raw'] = file_get_contents('php://input');
        if (! config('api-recorder.outgoing.fields.body_raw') ||
            (isset($filter['EXCLUDE']) && in_array('BODY', $filter['EXCLUDE']))
        ) {
            $data['body_raw'] = config('api-recorder.excluded_message');
        }

        $data['response'] = self::filterResponse($response->getContent(), $filter);

        $responseHeaders = $response->headers->all();
        $data['response_headers'] = self::filterHeaders($responseHeaders, $filter);

        $data['duration'] = static::getDuration();

        [$controller, $action] = static::getCurrentRoute();
        $data['controller'] = $controller;
        $data['action'] = $action;

        $data['models_retrieved'] = substr(json_encode($modelsRetrieved), 0, config('api-recorder.max_models_retrieved_size', 200));
        $data['from_ip'] = IpResolver::get($request);

        return $data;
    }

    protected static function getGlobalFilter(): array
    {
        return static::upperCase(config('api-recorder.incoming.mask'));
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
                if (is_string($currentRouteAction)) {
                    $action = $currentRouteAction;
                } else {
                    $action = json_encode($currentRouteAction);
                }
            }
        }

        return [$controller, $action];
    }
}
