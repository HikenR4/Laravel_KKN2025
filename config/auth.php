<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Authentication Defaults
    |--------------------------------------------------------------------------
    | PERBAIKAN: Jangan ubah default guard ke 'admin', biarkan 'web'
    | karena bisa mempengaruhi sistem Laravel lainnya
    */
    'defaults' => [
        'guard' => 'web',           // Tetap 'web' untuk default
        'passwords' => 'users',     // Tetap 'users' untuk default
    ],

    /*
    |--------------------------------------------------------------------------
    | Authentication Guards
    |--------------------------------------------------------------------------
    */
    'guards' => [
        'web' => [
            'driver' => 'session',
            'provider' => 'users',
        ],

        // Guard khusus untuk admin
        'admin' => [
            'driver' => 'session',
            'provider' => 'admins',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | User Providers
    |--------------------------------------------------------------------------
    */
    'providers' => [
        'users' => [
            'driver' => 'eloquent',
            'model' => App\Models\User::class,
        ],

        'admins' => [
            'driver' => 'eloquent',
            'model' => App\Models\Admin::class,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Resetting Passwords
    |--------------------------------------------------------------------------
    */
    'passwords' => [
        'users' => [
            'provider' => 'users',
            'table' => 'password_reset_tokens',
            'expire' => 60,
            'throttle' => 60,
        ],

        'admins' => [
            'provider' => 'admins',
            'table' => 'admin_password_resets',  // PERBAIKAN: Gunakan tabel khusus untuk admin
            'expire' => 60,
            'throttle' => 60,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Password Confirmation Timeout
    |--------------------------------------------------------------------------
    */
    'password_timeout' => 10800,

    /*
    |--------------------------------------------------------------------------
    | Custom Settings for Admin Authentication
    |--------------------------------------------------------------------------
    */
    'max_attempts' => env('AUTH_MAX_ATTEMPTS', 5),
    'lockout_minutes' => env('AUTH_LOCKOUT_MINUTES', 15),
];
