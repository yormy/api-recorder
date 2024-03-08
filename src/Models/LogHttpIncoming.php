<?php

namespace Yormy\ApiRecorder\Models;

/**
 * Yormy\ApiRecorder\Models\LogHttpIncoming
 *
 * @method static \Illuminate\Database\Eloquent\Builder|LogHttpIncoming newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|LogHttpIncoming newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|LogHttpIncoming query()
 * @mixin \Eloquent
 */
class LogHttpIncoming extends BaseModel
{
    protected $table = 'api_recorder_incoming';

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
        'user_id',
        'user_type',
    ];

    protected $casts = [
        'models_retrieved' => 'array',
    ];
}
