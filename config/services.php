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

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'stripe' => [
        'model' => App\Models\Auth\User::class,
        // 'key' => env('STRIPE_KEY', 'pk_live_ut3XHkZWlA0NgeL5yQAmHSTz'),
        // 'secret' => env('STRIPE_SECRET', 'sk_live_RDmE4YBpXydnqJsFhjU4RQgN00nzPZuaWh'),
        // 'key' => env('STRIPE_KEY', 'pk_test_rdcdd1KeaVgiywKV3hor8t8Z'),
        // 'secret' => env('STRIPE_SECRET', 'sk_test_u14mJq0oi4DZeC3X9uwhk4cu'),
        'key' => env('STRIPE_KEY', 'pk_test_xehWiOnlgbdoVvhiFV5RkxMv'),
        'secret' => env('STRIPE_SECRET', 'sk_test_vVrWMlThYpOGe0HQoaoyxydQ'),
        'webhook' => [
            'secret' => env('STRIPE_WEBHOOK_SECRET'),
            'tolerance' => env('STRIPE_WEBHOOK_TOLERANCE', 300),
        ],
    ],

];
