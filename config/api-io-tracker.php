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
    'outgoing_url_guards' => [
        'include' => [
            UrlGuardConfig::make('*'),
        ],
        'exclude' => [
            UrlGuardConfig::make('https://example-failed*'),
        ],
    ],

    'incoming_url_guards' => [
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
    |  Fields to log
    |--------------------------------------------------------------------------
    */
    'fields'=> [
        'outgoing' => [
            'body_raw' => false  // raw body payload // php://input
        ]
    ]
];
