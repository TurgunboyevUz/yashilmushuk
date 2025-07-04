<?php

use App\Models\Order;

return [
    'default' => 'default', // default app

    'apps'        => [
        'default' => [
            'model'       => Order::class,
            'multi_transaction' => false,

            'account'     => 'order_id',

            'merchant_id' => env('PAYME_MERCHANT_ID', '123456'),
            'key'         => env('PAYME_KEY', '123456'),
            'login'       => env('PAYME_LOGIN', 'Paycom'),

            'min_amount'  => env('PAYME_MIN_AMOUNT', 1) * 100, // convert so'm to tiyin
            'max_amount'  => env('PAYME_MAX_AMOUNT', 1000000) * 100, //convert so'm to tiyin
        ],
    ],

    'redirect_route' => [
        'path' => 'payme', // {path}/redirect/{id}/{amount}/{?app}
        'name' => 'payme.redirect',
    ],

    'callback_route' => [
        'path' => 'payme', // {path}/callback/{app?}
        'name' => 'payme.callback',
    ],

    'allowed_ips' => [
        "127.0.0.1",
        "185.234.113.1",
        "185.234.113.2",
        "185.234.113.3",
        "185.234.113.4",
        "185.234.113.5",
        "185.234.113.6",
        "185.234.113.7",
        "185.234.113.8",
        "185.234.113.9",
        "185.234.113.10",
        "185.234.113.11",
        "185.234.113.12",
        "185.234.113.13",
        "185.234.113.14",
        "185.234.113.15",
    ],
];
