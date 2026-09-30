<?php

return [
    'enabled'        => env('SPRINTVERIFY_ENABLED', false),
    'base_url'       => env('SPRINTVERIFY_BASE_URL', 'https://uat.paysprint.in/sprintverify-uat'),
    'authorised_key' => env('SPRINTVERIFY_AUTHORISEDKEY', ''),
    'partner_id'     => env('SPRINTVERIFY_PARTNER_ID', 'CORP00001'),
    'jwt_secret'     => env('SPRINTVERIFY_JWT_SECRET', ''),
    'static_token'   => env('SPRINTVERIFY_STATIC_TOKEN', ''),
    'timeout'        => env('SPRINTVERIFY_TIMEOUT', 30),
    'verify_ssl'     => env('SPRINTVERIFY_VERIFY_SSL', false),
];
