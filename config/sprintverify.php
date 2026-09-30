<?php

return [

    /*
    |--------------------------------------------------------------------------
    | PaySprint SprintVerify – Aadhaar OTP (KYC)
    |--------------------------------------------------------------------------
    | Send OTP to Aadhaar-linked mobile, verify OTP for Aadhaar verification.
    | UAT: https://uat.paysprint.in/sprintverify-uat
    | SIT: https://sit.paysprint.in (adjust path if different for SprintVerify)
    */

    'enabled' => env('SPRINTVERIFY_ENABLED', false),

    'base_url' => rtrim(env('SPRINTVERIFY_BASE_URL', 'https://uat.paysprint.in/sprintverify-uat'), '/'),

    'paths' => [
        'send_otp'   => env('SPRINTVERIFY_PATH_SEND_OTP', '/api/v1/verification/aadhaar_otp_send'),
        'verify_otp' => env('SPRINTVERIFY_PATH_VERIFY_OTP', '/api/v1/verification/aadhaar_otp_verify'),
    ],

    'token' => env('SPRINTVERIFY_TOKEN', ''),
    'authorisedkey' => env('SPRINTVERIFY_AUTHORISEDKEY', ''),
    'user_agent' => env('SPRINTVERIFY_USER_AGENT', 'CORP00001'),
    'timeout' => (int) env('SPRINTVERIFY_TIMEOUT', 30),
    'verify_ssl' => env('SPRINTVERIFY_VERIFY_SSL', true),

];
