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
    'enabled' => true,

    /*
    |--------------------------------------------------------------------------
    | Incoming Configuration
    |--------------------------------------------------------------------------
    |
    */
    'incoming' => [
        'enabled' => true,

        'prune_after_days' => 365,

        /*
        |--------------------------------------------------------------------------
        | What fields to mask
        |--------------------------------------------------------------------------
        | ie: password
        */
        'mask' => [
            'headers' => [],
            'body' => [],
            'response' => [],
        ],

        'url_guards' => [
            'include' => [
                UrlGuardConfig::make('*'),
            ],
            'exclude' => [
                UrlGuardConfig::make('https://example-failed*'),
            ],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Outgoing Configuration
    |--------------------------------------------------------------------------
    |
    */
    'outgoing' => [
        'enabled' => true,

        'prune_after_days' => 365,

        /*
        |--------------------------------------------------------------------------
        | What fields to mask
        |--------------------------------------------------------------------------
        | ie: password
        */
        'mask' => [
            'headers' => [],
            'body' => [],
            'response' => [],
        ],

        'fields' => [
            'body_raw' => false,  // log raw body payload // php://input
        ],

        'url_guards' => [
            'include' => [
                UrlGuardConfig::make('*'),
                UrlGuardConfig::make('https://api.stripe*', ['*'], [
                    'mask' => [
                        'headers' => ['AUTHORIZATION'],
                    ],
                ]),
            ],
            'exclude' => [
                UrlGuardConfig::make('https://example-failed*'),
            ],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | The strings that are in the database when a field is excluded or masked
    |--------------------------------------------------------------------------
    |
    */
    'excluded_message' => '*** EXCLUDED ***',
    'masked_message' => '**** MASKED ***',

    /*
    |--------------------------------------------------------------------------
    | Limit the sizes of the log
    |--------------------------------------------------------------------------
    |
    */
    'max_body_size' => 5000,
    'max_response_size' => 5000,
    'max_header_size' => 5000,
    'max_models_retrieved_size' => 5000,

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
    | Stripe specific
    |--------------------------------------------------------------------------
    |
    */
    'stripe' => [
        'enabled' => false,
    ],
];
