<?php

namespace Yormy\ApiIoTracker\Domain\HttpLogger\Models;

use Yormy\ApiIoTracker\Models\BaseModel;

class LogHttpOutgoing extends BaseModel
{
    protected $table = 'log_http_outgoing';

    protected $fillable = [
        'status',
        'url',
        'method',
        'headers',
        'body',
        'response',
    ];

    protected $casts = [
        'headers' => 'array'
    ];
}
