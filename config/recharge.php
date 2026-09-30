<?php

return [
    'enabled'   => env('RECHARGE_API_ENABLED', false),
    'base_url'  => env('RECHARGE_API_BASE_URL', 'https://sit.paysprint.in'),
    'authorised_key' => env('RECHARGE_AUTHORISEDKEY', ''),
    'token'     => env('RECHARGE_TOKEN', ''),
    'partner_id' => env('RECHARGE_PARTNER_ID', ''),
    'jwt_secret' => env('RECHARGE_JWT_SECRET', ''),
    'timeout'   => env('RECHARGE_TIMEOUT', 30),
    'verify_ssl' => env('RECHARGE_VERIFY_SSL', false),
];
