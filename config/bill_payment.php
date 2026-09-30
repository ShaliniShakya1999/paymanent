<?php

return [

    'enabled' => env('BILL_PAYMENT_API_ENABLED', true),
    'base_url' => rtrim(env('BILL_PAYMENT_API_BASE_URL', 'https://sit.paysprint.in'), '/'),
    'paths' => [
        'get_operator' => env('BILL_PAYMENT_PATH_GET_OPERATOR', '/service-api/api/v1/service/bill-payment/bill/getoperator'),
        'fetch_bill'   => env('BILL_PAYMENT_PATH_FETCH_BILL', '/service-api/api/v1/service/bill-payment/bill/fetchbill'),
        'pay_bill'     => env('BILL_PAYMENT_PATH_PAY_BILL', '/service-api/api/v1/service/bill-payment/bill/paybill'),
        'status'       => env('BILL_PAYMENT_PATH_STATUS', '/service-api/api/v1/service/bill-payment/bill/status'),
    ],
    'authorisedkey' => env('BILL_PAYMENT_AUTHORISEDKEY', env('RECHARGE_AUTHORISEDKEY', '')),
    'token' => env('BILL_PAYMENT_TOKEN', env('RECHARGE_TOKEN', '')),
    'timeout' => (int) env('BILL_PAYMENT_TIMEOUT', 30),
    'verify_ssl' => env('BILL_PAYMENT_VERIFY_SSL', true),

];
