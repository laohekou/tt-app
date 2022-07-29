<?php

namespace Xyu\TtApp;

use Xyu\TtApp\Contract\AbstractGateway;

class Order extends AbstractGateway
{
    /**
     * 小程序订单同步
     * @param array $params
     * @return mixed|\Psr\Http\Message\StreamInterface
     */
    public function push(array $params)
    {
        $result = $this->app->http->json('https://developer.toutiao.com/api/apps/order/v2/push', array_merge([
            'access_token' => $this->app->access_token->get_lock_token(),
        ], $params))->getBody();

        return json_decode((string)$result, true) ?: $result;
    }
}