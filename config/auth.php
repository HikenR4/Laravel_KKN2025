<?php

return [
    'defaults' => [
        'guard' => 'admin',
        'passwords' => 'admins',
    ],
    'guards' => [
        'admin' => [
            'driver' => 'session',
            'provider' => 'admins',
        ],
    ],
    'providers' => [
        'admins' => [
            'driver' => 'eloquent',
            'model' => App\Models\Admin::class,
        ],
    ],
    'passwords' => [
        'admins' => [
            'provider' => 'admins',
            'table' => 'admin',
            'expire' => 60,
        ],
    ],
    'max_attempts' => env('AUTH_MAX_ATTEMPTS', 5),
    'lockout_minutes' => env('AUTH_LOCKOUT_MINUTES', 15),
];
