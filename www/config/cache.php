<?php

/**
 * Cache Configuration
 */

return [

    'default' => env('CSTR_CACHE_DRIVER', 'file'),
    'stores' => [

        'apc' => [
            'driver' => 'apc',
        ],

        'array' => [
            'driver' => 'array',
        ],

        'database' => [
            'driver' => 'database',
            'table' => 'cache',
            'connection' => 'castoro',
        ],

        'file' => [
            'driver' => 'file',
            'path' => cstr_data_path('app/cache'),
        ],

        'memcached' => [
            'driver' => 'memcached',
            'persistent_id' => env('CSTR_APP_MEMCACHED_PERSISTENT_ID'),
            'sasl' => [
                env('CSTR_APP_MEMCACHED_USERNAME'),
                env('CSTR_APP_MEMCACHED_PASSWORD'),
            ],
            'options' => [
                // Memcached::OPT_CONNECT_TIMEOUT => 2000,
            ],
            'servers' => [
                [
                    'host' => env('CSTR_APP_MEMCACHED_HOST', '127.0.0.1'),
                    'port' => env('CSTR_APP_MEMCACHED_PORT', 11211),
                    'weight' => 100,
                ],
            ],
        ],

        'redis' => [
            'driver' => 'redis',
            'connection' => env('CSTR_APP_CACHE_REDIS_CONNECTION', 'cache'),
        ],

    ],
    'prefix' => 'castoro_cache',
];
