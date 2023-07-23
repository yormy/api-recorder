<?php

use Yormy\ApiIoTracker\Domain\Create\Models\TranslatableMailTemplate;
use Yormy\ApiIoTracker\Domain\Tracking\Models\SentEmail;
use Yormy\ApiIoTracker\Domain\Tracking\Models\SentEmailLog;
use Yormy\ApiIoTracker\Services\Resolvers\Encryptor;
use Yormy\ApiIoTracker\Services\Resolvers\IpResolver;
use Yormy\ApiIoTracker\Tests\Models\User;

return [

    'url_tracking' => [
        'in' =>[
            'only' => [],
            'except' => [
                'https://www.nu.nl' => ['*']
            ]
        ],
        'out' =>[
            'only' => [],
            'except' => [
                'https://www.nu.nl' => ['*']
            ]
        ]
    ],

    'field_masking' => [
        'in' => [
            'headers' => [],
            'request' => [],
            'response' => [],
        ],
        'out' => [
            'headers' => [],
            'request' => [],
            'response' => [],
        ]
    ],

    'resolvers' => [
        'ip' => IpResolver::class,
        'encryptor' => Encryptor::class
    ],

    'prune_after_days' => 365,

    'masked_as' => '*** CONTENT NOT STORED FOR SECURITY ***',
];
