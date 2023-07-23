# Api Io Tracker

![yormy](../../public/yormy.png)

::: tip Definition

:::

## Goal

## Features


# Goal

# Example

# Config
    'url_guards' => [
        'include' => [
            UrlGuardConfig::make('*'),
        ],
        'exclude' => [
            UrlGuardConfig::make('https://example-failed*'),
        ]
    ],

# Specify which urls to include/ exclude
More info on how to include / exclude urls [String Guard](https://yormy.github.io/string-guard/docs/)


# Exclude fields
```
    UrlGuardConfig::make('*', ['*'], ['exclude' => ['headers', 'body', 'response']),
```

# Mask fields per url
        $data = [
            'mask' => [
                'headers' => ['user-agent'],
                'body' => ['hello'],
            ]
        ];

        $urlGuard = [
            'include' => [
                UrlGuardConfig::make('*', ['*'], $data),
            ],
            'exclude' => [
            ]
        ];

# Mask global
    'field_masking' => [
        'incoming' => [
            'headers' => [],
            'body' => [],
            'response' => [],
        ],
        'outgoing' => [
            'headers' => ['host'],
            'body' => ['hello'],
            'response' => [],
        ]
    ],
