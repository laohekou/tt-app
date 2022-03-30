<?php

return [
    'debug' => env('TT_DEBUG', true),

    'default' => env('TT_DEFAULT_APP', 'default'),

    'drivers' => [
        'default' => [
            'timout' => 5,
            'access_key' => env('TT_APP_ID'),
            'secret_key' => env('TT_APP_SECRET'),

            'payment_app_id' => env('TT_PAYMENT_APP_ID'),
            'payment_merchant_id' => env('TT_PAYMENT_MERCHANT_ID'),
            'payment_secret' => env('TT_PAYMENT_SECRET'),
            'payment_salt' => env('TT_PAYMENT_SALT'),
            'payment_token' => env('TT_PAYMENT_TOKEN'),
            'cache' => make(\Xyu\TtApp\Hyperf\HyperfRedisCache::class), // 可选参数，你也可以用 \Doctrine\Common\Cache\ 下面得其它缓存驱动
        ]
    ],
];
