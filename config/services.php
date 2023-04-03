<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
        'endpoint' => env('MAILGUN_ENDPOINT', 'api.mailgun.net'),
        'scheme' => 'https',
    ],

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'mailtrap' => [
        'local' => [
            'api_url' => env('MAILTRAP_API_URL_DEV'),
            'api_token' => env('MAILTRAP_API_TOKEN_DEV'),
            'inbox_id' => env('MAILTRAP_INBOX_ID_DEV'),
        ],
        'testing' => [
            'api_url' => env('MAILTRAP_API_URL_DEV'),
            'api_token' => env('MAILTRAP_API_TOKEN_DEV'),
            'inbox_id' => env('MAILTRAP_INBOX_ID_DEV'),
        ],
        'prod' => [
            'api_url' => env('MAILTRAP_API_URL'),
            'api_token' => env('MAILTRAP_API_TOKEN'),
        ],
    ]

];
