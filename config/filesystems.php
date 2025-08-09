<?php
return [
    'default' => env('FILESYSTEM_DISK', 'local'),

    'disks' => [
        'local' => [
            'driver' => 'local',
            'root' => storage_path('app/private'),
            'serve' => true,
            'throw' => false,
            'report' => false,
        ],

        'public' => [
            'driver' => 'local',
            'root' => storage_path('app/public'),
            'url' => env('APP_URL').'/storage',
            'visibility' => 'public',
            'throw' => false,
            'report' => false,
        ],

        // TAMBAHAN: Disk khusus untuk video
        'videos' => [
            'driver' => 'local',
            'root' => public_path('uploads/videos'),    // public/uploads/videos
            'url' => env('APP_URL').'/uploads/videos',  // http://localhost/uploads/videos
            'visibility' => 'public',
            'throw' => false,
        ],

        // TAMBAHAN: Disk untuk semua media nagari
        'nagari_media' => [
            'driver' => 'local',
            'root' => public_path('uploads'),           // public/uploads
            'url' => env('APP_URL').'/uploads',         // http://localhost/uploads
            'visibility' => 'public',
            'throw' => false,
        ],

        's3' => [
            'driver' => 's3',
            'key' => env('AWS_ACCESS_KEY_ID'),
            'secret' => env('AWS_SECRET_ACCESS_KEY'),
            'region' => env('AWS_DEFAULT_REGION'),
            'bucket' => env('AWS_BUCKET'),
            'url' => env('AWS_URL'),
            'endpoint' => env('AWS_ENDPOINT'),
            'use_path_style_endpoint' => env('AWS_USE_PATH_STYLE_ENDPOINT', false),
            'throw' => false,
            'report' => false,
        ],
    ],

    'links' => [
        public_path('storage') => storage_path('app/public'),
        // TAMBAHAN: Link untuk media uploads
        public_path('uploads') => storage_path('app/nagari_media'),
    ],
];
