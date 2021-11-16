<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default Filesystem Disk
    |--------------------------------------------------------------------------
    |
    | Here you may specify the default filesystem disk that should be used
    | by the framework. The "local" disk, as well as a variety of cloud
    | based disks are available to your application. Just store away!
    |
    */

    'default' => env('FILESYSTEM_DRIVER', 'local'),

    /*
    |--------------------------------------------------------------------------
    | Default Cloud Filesystem Disk
    |--------------------------------------------------------------------------
    |
    | Many applications store files both locally and in the cloud. For this
    | reason, you may specify a default "cloud" driver here. This driver
    | will be bound as the Cloud disk implementation in the container.
    |
    */

    'cloud' => env('FILESYSTEM_CLOUD', 's3'),

    /*
    |--------------------------------------------------------------------------
    | Filesystem Disks
    |--------------------------------------------------------------------------
    |
    | Here you may configure as many filesystem "disks" as you wish, and you
    | may even configure multiple disks of the same driver. Defaults have
    | been setup for each driver as an example of the required options.
    |
    | Supported Drivers: "local", "ftp", "sftp", "s3"
    |
    */

    'disks' => [

        'local' => [
            'driver' => 'local',
            'root' => storage_path('app'),
        ],

        'public' => [
            'driver' => 'local',
            'root' => storage_path('app/public'),
            'url' => env('APP_URL').'/storage',
            'visibility' => 'public',
        ],

        's3' => [
            'driver' => 's3',
            'key' => env('AWS_ACCESS_KEY_ID'),
            'secret' => env('AWS_SECRET_ACCESS_KEY'),
            'region' => env('AWS_DEFAULT_REGION'),
            'bucket' => env('AWS_BUCKET'),
            'url' => env('AWS_URL'),
            'endpoint' => env('AWS_ENDPOINT'),
        ],

        'import_format' => [
            'driver' => 'local',
            'root' => storage_path('app/public/import_format'),
            'url' => env('APP_URL').'/storage/import_format',
            'visibility' => 'public',
        ],

        'group_site_logo' => [
            'driver' => 'local',
            'root' => storage_path('app/public/images/group-site'),
            'url' => env('APP_URL').'/storage/images/group-site',
            'visibility' => 'public',
        ],

        'employee_photo' => [
            'driver' => 'local',
            'root' => storage_path('app/public/images/employee'),
            'url' => env('APP_URL').'/storage/images/employee',
            'visibility' => 'public',
        ],

        'user_photo' => [
            'driver' => 'local',
            'root' => storage_path('app/public/images/user'),
            'url' => env('APP_URL').'/storage/images/user',
            'visibility' => 'public',
        ],

        'main_image' => [
            'driver' => 'local',
            'root' => storage_path('app/public/images/main'),
            'url' => env('APP_URL').'/storage/images/main',
            'visibility' => 'public',
        ],

        'inventory_image' => [
            'driver' => 'local',
            'root' => storage_path('app/public/images/inventory'),
            'url' => env('APP_URL').'/storage/images/inventory',
            'visibility' => 'public',
        ],

        'lampiran_maintenance' => [
            'driver' => 'local',
            'root' => storage_path('app/public/files/inventory/maintenance'),
            'url' => env('APP_URL').'/storage/files/inventory/maintenance',
            'visibility' => 'public',
        ],

        'import_inventory' => [
            'driver' => 'local',
            'root' => storage_path('app/public/files/inventory/import'),
            'url' => env('APP_URL').'/storage/files/inventory/import',
            'visibility' => 'public',
        ],

        'ga_persuratan_lampiran' => [
            'driver' => 'local',
            'root' => storage_path('app/public/files/persuratan/lampiran'),
            'url' => env('APP_URL').'/storage/files/persuratan/lampiran',
            'visibility' => 'public',
        ],

    ],

    /*
    |--------------------------------------------------------------------------
    | Symbolic Links
    |--------------------------------------------------------------------------
    |
    | Here you may configure the symbolic links that will be created when the
    | `storage:link` Artisan command is executed. The array keys should be
    | the locations of the links and the values should be their targets.
    |
    */

    'links' => [
        public_path('storage') => storage_path('app/public'),
    ],

];
