<?php

return [
    'apiperudev' => [
        'url'   => env('APIPERUDEV_URL', 'https://my.apiconsulta.dev/api'),
        'token' => env('APIPERUDEV_TOKEN'),
    ],

    'ws' => [
        'url'   => env('WS_API_URL'),
        'token' => env('WS_API_TOKEN'),
    ],
];
