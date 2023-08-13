<?php

namespace Yormy\ApiIoTracker\Models;

class LogHttpOutgoing extends BaseModel
{
    protected $table = 'log_http_outgoing';

    protected $fillable = [
        'status_code',
        'status',
        'url',
        'method',
        'headers',
        'body',
        'response',
        'user_id',
        'user_type'
    ];
}
