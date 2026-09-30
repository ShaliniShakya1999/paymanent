<?php

return [
    'enabled'     => env('BUS_BOOKING_API_ENABLED', false),
    'base_url'    => env('BUS_BOOKING_API_BASE_URL', ''),
    'token'       => env('BUS_BOOKING_API_TOKEN', ''),
    'authorised_key' => env('BUS_BOOKING_AUTHORISEDKEY', ''),
    'timeout'     => (int) env('BUS_BOOKING_API_TIMEOUT', 45),
    'verify_ssl'  => (bool) env('BUS_BOOKING_VERIFY_SSL', false),
];
