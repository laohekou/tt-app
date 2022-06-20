<?php

namespace Xyu\TtApp\Douyin;

use Xyu\TtApp\Contract\AbstractGateway;

class PreparceOrder extends AbstractGateway
{
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
                'access-token' => $this->dyAccessToken()
            ],
            \GuzzleHttp\RequestOptions::JSON => $params
        ])->getBody();

        $resp = json_decode((string)$result, true) ?: $result;

        if($resp) {
            if(true === $this->checkToken((int)$resp['error_code'])) {
                // todo 如果token原因，重试业务接口。
                $result = $this->cancelPrepareCode($params);
                return json_decode((string)$result, true) ?: $result;
            }
        }

        return $resp;
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
                'access-token' => $this->dyAccessToken()
            ],
            \GuzzleHttp\RequestOptions::JSON => [
                'code_list' => $params['code'],
                'open_id' => $params['openid'],
                'order_id' => $params['order_id'], // 抖音生活服务订单ID
            ]
        ])->getBody();

        $resp = json_decode((string)$result, true) ?: $result;

        if($resp) {
            if(true === $this->checkToken((int)$resp['error_code'])) {
                // todo 如果token原因，重试业务接口。
                $result = $this->prepareCode($params);
                return json_decode((string)$result, true) ?: $result;
            }
        }

        return $resp;
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
                'access-token' => $this->dyAccessToken()
            ],
            \GuzzleHttp\RequestOptions::JSON => [
                'code_list' => $params['code'],
                'open_id' => $params['openid'],
                'order_ext_id' => $params['order_ext_id'], // 接入方订单ID
            ]
        ])->getBody();

        $resp = json_decode((string)$result, true) ?: $result;

        if($resp) {
            if(true === $this->checkToken((int)$resp['data']['error_code'])) {
                // todo 如果token原因，重试业务接口。
                $result = $this->prepare($params);
                return json_decode((string)$result, true) ?: $result;
            }
        }

        return $resp;
    }
}