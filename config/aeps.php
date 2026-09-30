<?php

return [
    'enabled'     => env('AEPS_API_ENABLED', false),
    'base_url'    => env('AEPS_API_BASE_URL', ''),
    'token'       => env('AEPS_API_TOKEN', ''),
    'api_key'     => env('AEPS_API_KEY', ''),
    'timeout'     => (int) env('AEPS_API_TIMEOUT', 30),
    'verify_ssl'  => (bool) env('AEPS_VERIFY_SSL', false),
];
