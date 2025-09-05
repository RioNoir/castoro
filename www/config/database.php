<?php

/**
 * Database Configuration
 */

return [

    'default' => env('CSTR_DB_CONNECTION', 'default'),
    'connections' => [

        'default' => [
            'driver' => 'sqlite',
            'database' => cstr_data_path('/app/database.sqlite'),
            'prefix' => '',
        ],

        'jellyfin' => [
            'driver' => 'sqlite',
            'database' => cstr_data_path('/jellyfin/data/jellyfin.db'),
            'prefix' => '',
        ],

        'library' => [
            'driver' => 'sqlite',
            'database' => cstr_data_path('/jellyfin/data/library.db'),
            'prefix' => '',
        ],

        'mysql' => [
            'driver' => 'mysql',
            'host' => env('CSTR_DB_HOST', '127.0.0.1'),
            'port' => env('CSTR_DB_PORT', 3306),
            'database' => env('CSTR_DB_DATABASE', 'forge'),
            'username' => env('CSTR_DB_USERNAME', 'forge'),
            'password' => env('CSTR_DB_PASSWORD', ''),
            'unix_socket' => env('CSTR_DB_SOCKET', ''),
            'charset' => env('CSTR_DB_CHARSET', 'utf8mb4'),
            'collation' => env('CSTR_DB_COLLATION', 'utf8mb4_unicode_ci'),
            'prefix' => env('CSTR_DB_PREFIX', ''),
            'strict' => env('CSTR_DB_STRICT_MODE', false),
            'engine' => env('CSTR_DB_ENGINE'),
            'timezone' => env('CSTR_DB_TIMEZONE', '+00:00'),
        ],
    ],
    'migrations' => 'migrations',
];
