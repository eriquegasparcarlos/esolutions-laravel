<?php

return [
    'app' => [
        'url_base'         => env('APP_URL_BASE'),
        'subdomain_system' => env('APP_SUBDOMAIN_SYSTEM', 'administration'),
        'color_primary'    => env('APP_COLOR_PRIMARY', '#D43759'),
        'type'             => env('APP_TYPE', 'pos'),
    ],

    'tenancy' => [
        'database_prefix' => env('TENANCY_DATABASE_PREFIX'),
    ],

    'support' => [
        'email' => env('SUPPORT_EMAIL'),
        'name'  => env('SUPPORT_NAME', 'Soporte'),
    ],

    'apiperudev' => [
        'url'   => env('APIPERUDEV_URL', 'https://my.apiconsulta.dev/api'),
        'token' => env('APIPERUDEV_TOKEN'),
    ],

    'ws' => [
        'url'   => env('WS_API_URL'),
        'token' => env('WS_API_TOKEN'),
    ],

    'igv' => [
        'start'      => env('IGV_31556_START', '2022-09-01'),
        'end'        => env('IGV_31556_END', '2026-12-31'),
        'percentage' => env('IGV_31556_PERCENTAGE', 0.10),
    ],
];
