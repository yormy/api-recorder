<?php

namespace Yormy\ApiIoTracker\Models;

/**
 * Yormy\ApiIoTracker\Models\LogHttpOutgoing
 *
 * @method static \Illuminate\Database\Eloquent\Builder|LogHttpOutgoing newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|LogHttpOutgoing newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|LogHttpOutgoing query()
 * @mixin \Eloquent
 */
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
        'user_type',
    ];
}
