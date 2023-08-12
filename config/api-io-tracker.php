<?php

use Yormy\ApiIoTracker\Services\Resolvers\Encryptor;
use Yormy\ApiIoTracker\Services\Resolvers\IpResolver;
use Yormy\StringGuard\DataObjects\UrlGuardConfig;

return [

    /*
    |--------------------------------------------------------------------------
    | Enabled
    |--------------------------------------------------------------------------
    |
    */

    'enabled_incoming' => true,
    'enabled_outgoing' => true,

    'excluded_message' => '*** EXCLUDED ***',
    'masked_message' => '**** MASKED ***',

    /*
    |--------------------------------------------------------------------------
    | What urls to track
    |--------------------------------------------------------------------------
    |
    */
    'url_guards' => [
        'include' => [
            UrlGuardConfig::make('*'),
        ],
        'exclude' => [
            UrlGuardConfig::make('https://example-failed*'),
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | What fields to mask
    |--------------------------------------------------------------------------
    | ie: password
    */

    'field_masking' => [
        'incoming' => [
            'headers' => [],
            'body' => [],
            'response' => [],
        ],
        'outgoing' => [
            'headers' => [],
            'body' => [],
            'response' => [],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Overridable helper functions
    |--------------------------------------------------------------------------
    |
    */
    'resolvers' => [
        'ip' => IpResolver::class,
        'encryptor' => Encryptor::class,
    ],

    /*
    |--------------------------------------------------------------------------
    | Prune
    |--------------------------------------------------------------------------
    |
    */
    'prune_after_days' => 365,

    /*
|--------------------------------------------------------------------------
|  Log raw payload
|--------------------------------------------------------------------------
|
| This will log the raw request from php://input so you will get all details
| BUT this will also log the exclusions, since we are not able to find field
| in the php://input, by default we use request()->all() encoded in JSON
|
*/
    'body_raw' => true,

];
