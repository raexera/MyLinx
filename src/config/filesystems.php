<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default Filesystem Disk
    |--------------------------------------------------------------------------
    |
    | MyLinx uses the "public" disk exclusively for all user-uploaded media
    | (product images, logos, etc.) via spatie/laravel-medialibrary.
    |
    */

    'default' => env('FILESYSTEM_DISK', 'public'),

    /*
    |--------------------------------------------------------------------------
    | Filesystem Disks
    |--------------------------------------------------------------------------
    |
    | Only local and public disks are configured. This MVP does not use any
    | cloud storage services (S3, GCS, etc.) as per project constraints.
    |
    */

    'disks' => [

        'local' => [
            'driver' => 'local',
            'root' => storage_path('app/private'),
            'serve' => true,
            'throw' => false,
        ],

        'public' => [
            'driver' => 'local',
            'root' => storage_path('app/public'),
            'url' => env('APP_URL') . '/storage',
            'visibility' => 'public',
            'throw' => false,
        ],

    ],

    /*
    |--------------------------------------------------------------------------
    | Symbolic Links
    |--------------------------------------------------------------------------
    |
    | The "storage:link" Artisan command creates a symlink from
    | public/storage → storage/app/public so uploaded files are web-accessible.
    |
    */

    'links' => [
        public_path('storage') => storage_path('app/public'),
    ],

];
