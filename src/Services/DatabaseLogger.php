<?php

namespace Yormy\ApiIoTracker\Services;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Yormy\ApiIoTracker\DataObjects\LogIncomingData;
use Yormy\ApiIoTracker\Models\LogHttpIncoming;

class DatabaseLogger extends BaseLogger
{
    public $logModel;

    public function __construct(LogHttpIncoming $logModel)
    {
        parent::__construct();
        $this->logModel = $logModel;
    }

    public function saveLogs(Request $request, Response|JsonResponse|RedirectResponse $response, array $data)
    {
        $data = LogIncomingData::make($request, $response, $data, $this->modelsRetrieved);

        $this->logModel->create($data);
    }
}
