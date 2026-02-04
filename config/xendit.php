<?php

return [
    'secret_key' => env('XENDIT_SECRET_KEY'),
    'public_key' => env('XENDIT_PUBLIC_KEY'),
    'mode' => env('XENDIT_MODE'),
    'callback_token' => env('XENDIT_CALLBACK_TOKEN', env('XENDIT_WEBHOOK_TOKEN')),
    'verify_ssl' => env('XENDIT_VERIFY_SSL', true),
    'invoice' => [
        'base_url' => env('XENDIT_INVOICE_BASE_URL', 'https://api.xendit.co'),
        'duration_seconds' => (int) env('XENDIT_INVOICE_DURATION_SECONDS', 3600),
    ],
    'redirect' => [
        'success_url' => env('XENDIT_SUCCESS_REDIRECT_URL'),
        'failure_url' => env('XENDIT_FAILURE_REDIRECT_URL'),
    ],
];
