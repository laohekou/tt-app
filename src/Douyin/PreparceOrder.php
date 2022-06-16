<?php

namespace Xyu\TtApp\Douyin;

use Xyu\TtApp\TtApp;

class PreparceOrder
{
    protected $app;

    public function __construct(TtApp $ttApp)
    {
        $this->app = $ttApp;
    }

    /**
     * 取消预核销预售券
     * @param array $params
     * @return mixed|\Psr\Http\Message\StreamInterface
     */
    public function cancelPrepareCode(array $params)
    {
        $result = $this->app->http->request('POST','https://open.douyin.com/poi/order/confirm/cancel_prepare', [
            \GuzzleHttp\RequestOptions::HEADERS => [
                'Content-Type' => 'application/json',
                'access-token' => $this->app->douyin_token->getToken()
            ],
            \GuzzleHttp\RequestOptions::JSON => $params
        ])->getBody();

        return json_decode((string)$result, true) ?: $result;
    }

    /**
     * 预核销预售券
     * @param array $params
     * @return mixed|\Psr\Http\Message\StreamInterface
     */
    public function prepareCode(array $params)
    {
        $result = $this->app->http->request('POST','https://open.douyin.com/poi/order/confirm/prepare', [
            \GuzzleHttp\RequestOptions::HEADERS => [
                'Content-Type' => 'application/json',
                'access-token' => $this->app->douyin_token->getToken()
            ],
            \GuzzleHttp\RequestOptions::JSON => [
                'code_list' => $params['code'],
                'open_id' => $params['openid'],
                'order_id' => $params['order_id'], // 抖音生活服务订单ID
            ]
        ])->getBody();

        return json_decode((string)$result, true) ?: $result;
    }

    /**
     * 核销预售券
     * @param array $params
     * @return mixed|\Psr\Http\Message\StreamInterface
     */
    public function prepare(array $params)
    {
        $result = $this->app->http->request('POST','https://open.douyin.com/poi/order/confirm', [
            \GuzzleHttp\RequestOptions::HEADERS => [
                'Content-Type' => 'application/json',
                'access-token' => $this->app->douyin_token->getToken()
            ],
            \GuzzleHttp\RequestOptions::JSON => [
                'code_list' => $params['code'],
                'open_id' => $params['openid'],
                'order_ext_id' => $params['order_ext_id'], // 接入方订单ID
            ]
        ])->getBody();

        return json_decode((string)$result, true) ?: $result;
    }
}