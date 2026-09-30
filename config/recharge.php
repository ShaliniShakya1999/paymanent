<?php

return [

    'enabled' => env('RECHARGE_API_ENABLED', true),

    'base_url' => rtrim(env('RECHARGE_API_BASE_URL', 'https://sit.paysprint.in'), '/'),

    'paths' => [
        'get_operator' => env('RECHARGE_PATH_GET_OPERATOR', '/service-api/api/v1/service/recharge/recharge/getoperator'),
        'do_recharge'  => env('RECHARGE_PATH_DO_RECHARGE', '/service-api/api/v1/service/recharge/recharge/dorecharge'),
        'status'       => env('RECHARGE_PATH_STATUS', '/service-api/api/v1/service/recharge/recharge/status'),
    ],

    'authorisedkey' => env('RECHARGE_AUTHORISEDKEY', ''),
    'token' => env('RECHARGE_TOKEN', ''),
    'timeout' => (int) env('RECHARGE_TIMEOUT', 30),
    'verify_ssl' => env('RECHARGE_VERIFY_SSL', true),

];
