<?php

namespace Yormy\ApiIoTracker\Models;

class LogHttpIncoming extends BaseModel
{
    protected $table = 'log_http_incoming';

    protected $fillable = [
        'status_code',
        'created_at',
        'method',
        'url',
        'body',
        'body_raw',
        'headers',
        'response',
        'response_headers',
        'duration',
        'controller',
        'action',
        'models_retrieved',
        'from_ip',
    ];

    protected $casts = [
        'models_retrieved' => 'array',
        'body' => 'array',
    ];
}
