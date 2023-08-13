# Configuration - TODO

- env variables







# Config what urls to include or exclude
```php
    'url_guards' => [
        'include' => [
            UrlGuardConfig::make('*'),
        ],
        'exclude' => [
            UrlGuardConfig::make('https://example-failed*'),
        ]
    ],
````

## Exclude fields
```php
    UrlGuardConfig::make('*', ['*'], ['exclude' => ['headers', 'body', 'response']),
```

### Specify which urls to include/ exclude
More info on how to include / exclude urls [String Guard](https://yormy.github.io/string-guard/docs/)




# Mask fields per url
```php
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
```

# Mask global
```php
    'outgoing' => [
        ...
        'mask' => [
            'headers' => [],
            'body' => [],
            'response' => [],
        ],
        ...
    ],
    
    'incoming' => [  
        ...      
        'mask' => [
            'headers' => ['host'],
            'body' => ['hello'],
            'response' => [],
        ]
        ...        
    ],
```


# Stripe
In order to log stripe outgoing calls you need to specifically enable this
```php
    'stripe' => [
        'enabled' => false,
    ],
```

::: danger SECURITY WARNING
Make sure you mask the authorization header, otherwize your stipe api key is logged in the database
:::
```php
    'outgoing' => [
        'enabled' => true,
        ...

        'url_guards' => [
            'include' => [
                UrlGuardConfig::make('https://api.stripe*', ['*'], [
                    'mask' => [
                        'headers' => ['AUTHORIZATION'], // [!code focus] // MASK FOR SECURITY
                    ],
                ]),
            ],
        ...
```
