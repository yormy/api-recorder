<?php

namespace Yormy\ApiIoTracker\Services;

use AWT\Contracts\ApiLoggerInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Yormy\ApiIoTracker\Domain\HttpLogger\Models\LogHttpIncoming;

class DBLogger extends AbstractLogger // implements ApiLoggerInterface{
{
    public $logModel;

    public function __construct(LogHttpIncoming $logModel)
    {
        parent::__construct();
        $this->logModel = $logModel;
    }

    public function saveLogs(Request $request, Response|JsonResponse|RedirectResponse $response)
    {
        $data = $this->logData($request, $response);
        $this->logModel->create($data);
    }
}
