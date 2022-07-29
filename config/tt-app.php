<?php

return [
    'debug' => env('TT_DEBUG', true),

    'default' => env('TT_DEFAULT_APP', 'default'),

    'drivers' => [
        'default' => [
            // 小程序配置
            'timout' => 5,
            'access_key' => env('MP_MINI_APPID'),
            'secret_key' => env('MP_MINI_SECRET'),

            'payment_app_id' => env('MP_MINI_PAYMENT_APPID'),
            'payment_merchant_id' => env('MP_MINI_PAYMENT_MERCHANTID'),
            'payment_secret' => env('MP_MINI_PAYMENT_SECRET'),
            'payment_salt' => env('MP_MINI_PAYMENT_SALT'),
            'payment_token' => env('MP_MINI_PAYMENT_TOKEN'),
            // 可选参数，你也可以用 \Doctrine\Common\Cache\ 下面得其它缓存驱动
            'cache' => make(\Xyu\TtApp\Hyperf\HyperfRedisCache::class),

            // 抖音开放平台配置
            'client_key' => env('MP_DY_KEY'),
            'client_secret' => env('MP_DY_SECRET'),
            'public_key' => env('MP_DY_PUBLIC_KEY'),
            'private_key' => env('MP_DY_PRIVATE_KEY'),
        ]
    ],
];
