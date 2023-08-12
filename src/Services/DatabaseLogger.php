<?php

namespace Yormy\ApiIoTracker\Services;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Yormy\ApiIoTracker\Domain\HttpLogger\Models\LogHttpIncoming;
use Yormy\ApiIoTracker\DTO\LogIncomingData;

class DatabaseLogger extends BaseLogger
{
    public $logModel;

    public function __construct(LogHttpIncoming $logModel)
    {
        parent::__construct();
        $this->logModel = $logModel;
    }

    public function saveLogs(Request $request, Response|JsonResponse|RedirectResponse $response)
    {
        $data = LogIncomingData::make($request, $response, [], $this->modelsRetrieved);

        $this->logModel->create($data);
    }
}
