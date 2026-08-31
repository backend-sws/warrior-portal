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

    'postmark' => [
        'key' => env('POSTMARK_API_KEY'),
    ],

    'resend' => [
        'key' => env('RESEND_API_KEY'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'slack' => [
        'notifications' => [
            'bot_user_oauth_token' => env('SLACK_BOT_USER_OAUTH_TOKEN'),
            'channel' => env('SLACK_BOT_USER_DEFAULT_CHANNEL'),
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Razorpay Payment Gateway (Commented Out)
    |--------------------------------------------------------------------------
    */
    /*
    'razorpay' => [
        'key_id'         => env('RAZORPAY_KEY_ID', 'rzp_test_placeholder'),
        'key_secret'     => env('RAZORPAY_KEY_SECRET', 'secret_placeholder'),
        'webhook_secret' => env('RAZORPAY_WEBHOOK_SECRET', ''),
        'currency'       => env('RAZORPAY_CURRENCY', 'INR'),
        'merchant_name'  => env('RAZORPAY_MERCHANT_NAME', 'Warriors Educare'),
    ],
    */

    /*
    |--------------------------------------------------------------------------
    | PhonePe Payment Gateway (Active)
    |--------------------------------------------------------------------------
    */
    'phonepe' => [
        // V2 Credentials (from PhonePe Business Dashboard)
        'client_id'       => env('PHONEPE_CLIENT_ID', ''),
        'client_secret'   => env('PHONEPE_CLIENT_SECRET', ''),
        'client_version'  => env('PHONEPE_CLIENT_VERSION', '1'),
        'webhook_secret'  => env('PHONEPE_WEBHOOK_SECRET', ''),
        'env'             => env('PHONEPE_ENV', 'UAT'), // 'UAT' or 'PRODUCTION'
        'currency'        => env('PHONEPE_CURRENCY', 'INR'),
        'merchant_name'   => env('PHONEPE_MERCHANT_NAME', 'Warriors Educare'),
        // V2 Auth Token URL
        'auth_url'        => strtoupper(env('PHONEPE_ENV', 'UAT')) === 'PRODUCTION'
                              ? 'https://api.phonepe.com/apis/identity-manager/v1/oauth/token'
                              : 'https://api-preprod.phonepe.com/apis/pg-sandbox/v1/oauth/token',
        // V2 Base API URL
        'base_url'        => strtoupper(env('PHONEPE_ENV', 'UAT')) === 'PRODUCTION'
                              ? 'https://api.phonepe.com/apis/pg'
                              : 'https://api-preprod.phonepe.com/apis/pg-sandbox',
    ],

];
