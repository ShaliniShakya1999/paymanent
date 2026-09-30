<?php

return [
    'enabled'   => env('BILL_PAYMENT_API_ENABLED', false),
    'base_url'  => env('BILL_PAYMENT_API_BASE_URL', 'https://sit.paysprint.in'),
    'authorised_key' => env('BILL_PAYMENT_AUTHORISEDKEY', ''),
    'token'     => env('BILL_PAYMENT_TOKEN', ''),
    'timeout'   => env('BILL_PAYMENT_TIMEOUT', 30),
    'verify_ssl' => env('BILL_PAYMENT_VERIFY_SSL', false),
    'default_latitude'  => env('BILL_PAYMENT_DEFAULT_LATITUDE', '0'),
    'default_longitude' => env('BILL_PAYMENT_DEFAULT_LONGITUDE', '0'),
];
