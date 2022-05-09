<?php

return [
    'debug' => env('TT_DEBUG', true),

    'default' => env('TT_DEFAULT_APP', 'default'),

    'drivers' => [
        'default' => [
            'timout' => 5,
            'access_key' => env('MP_TOUTIAO_APPID'),
            'secret_key' => env('MP_TOUTIAO_SECRET'),

            'payment_app_id' => env('MP_TOUTIAO_PAYMENT_APPID'),
            'payment_merchant_id' => env('MP_TOUTIAO_PAYMENT_MERCHANTID'),
            'payment_secret' => env('MP_TOUTIAO_PAYMENT_SECRET'),
            'payment_salt' => env('MP_TOUTIAO_PAYMENT_SALT'),
            'payment_token' => env('MP_TOUTIAO_PAYMENT_TOKEN'),
            // 可选参数，你也可以用 \Doctrine\Common\Cache\ 下面得其它缓存驱动
            'cache' => make(\Xyu\TtApp\Hyperf\HyperfRedisCache::class),
        ]
    ],
];
