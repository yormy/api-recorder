<?php

namespace Yormy\ApiIoTracker\Http\Middleware;

use Closure;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Yormy\ApiIoTracker\Domain\HttpLogger\Models\LogHttpIncoming;
use Yormy\ApiIoTracker\Services\DBLogger;

class LogIncomingRequest
{
    protected $dblogger;

    public function __construct()
    {
        $this->dblogger = new DBLogger(new LogHttpIncoming());
    }

    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        return $response;
    }

    public function terminate(Request $request, Response|JsonResponse|RedirectResponse $response)
    {
        $this->dblogger->saveLogs($request, $response);
    }
}
