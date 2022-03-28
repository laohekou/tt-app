<?php

namespace Xyu\TtApp;

class Order
{
    protected $app;

    public function __construct(TtApp $ttApp)
    {
        $this->app = $ttApp;
    }

    /**
     * 小程序订单同步
     * @param array $params
     * @return mixed|\Psr\Http\Message\StreamInterface
     */
    public function push(array $params)
    {
        $result = $this->app->http->json('https://developer.toutiao.com/api/apps/order/v2/push', array_merge([
            'access_token' => $this->app->access_token->getToken(),
        ], $params))->getBody();

        return json_decode((string)$result, true) ?: $result;
    }
}