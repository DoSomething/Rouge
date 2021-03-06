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
    ],

    'mandrill' => [
        'secret' => env('MANDRILL_SECRET'),
    ],

    'northstar' => [
        'grant' => 'authorization_code',
        'url' => env('NORTHSTAR_URL'),
        'authorization_code' => [
            'client_id' => env('NORTHSTAR_AUTH_ID'),
            'client_secret' => env('NORTHSTAR_AUTH_SECRET'),
            'scope' => [
                'user',
                'role:staff',
                'role:admin',
                'write',
                'activity',
            ],
            'redirect_uri' => '/login',
        ],
        'client_credentials' => [
            'client_id' => env('NORTHSTAR_CLIENT_ID'),
            'client_secret' => env('NORTHSTAR_CLIENT_SECRET'),
            'scope' => ['user', 'admin'],
        ],
    ],

    'blink' => [
        'url' => env('BLINK_URL'),
        'user' => env('BLINK_USERNAME'),
        'password' => env('BLINK_PASSWORD'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'stripe' => [
        'model' => App\User::class,
        'key' => env('STRIPE_KEY'),
        'secret' => env('STRIPE_SECRET'),
        'webhook' => [
            'secret' => env('STRIPE_WEBHOOK_SECRET'),
            'tolerance' => env('STRIPE_WEBHOOK_TOLERANCE', 300),
        ],
    ],

    'slack' => [
        'url' => env('SLACK_WEBHOOK_INTEGRATION_URL'),
    ],

    'customerio' => [
        'url' => 'https://track.customer.io/api/v1/',
        'username' => env('CUSTOMER_IO_USERNAME'),
        'password' => env('CUSTOMER_IO_PASSWORD'),
    ],

    'fastly' => [
        'url' => 'https://api.fastly.com/',
        'key' => env('FASTLY_API_TOKEN'),
        'service_id' => env('FASTLY_SERVICE_ID'),
    ],

    'graphql' => [
        'url' => env('GRAPHQL_URL'),
    ],
];
