<?php

namespace Yormy\ApiIoTracker\Http\Middleware;

use Closure;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Yormy\ApiIoTracker\Models\LogHttpIncoming;
use Yormy\ApiIoTracker\Services\DatabaseLogger;
use Yormy\StringGuard\Services\UrlGuard;

class LogIncomingRequest
{
    protected $dblogger;

    public function __construct()
    {
        $this->dblogger = new DatabaseLogger(new LogHttpIncoming());
    }

    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        return $response;
    }

    public function terminate(Request $request, Response|JsonResponse|RedirectResponse $response)
    {
        if (! config('api-io-tracker.enabled') || !config('api-io-tracker.incoming.enabled')) {
            return;
        }

        $url = $request->url();
        $method = $request->method();
        $config = config('api-io-tracker.incoming.url_guards');
        $include = UrlGuard::isIncluded($url, $method, $config);
        $data = UrlGuard::getData($url, $method, $config);

        if (! $include) {
            return;
        }

        $this->dblogger->saveLogs($request, $response, $data);
    }
}
