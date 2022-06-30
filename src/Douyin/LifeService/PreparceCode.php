<?php

namespace Xyu\TtApp\Douyin\LifeService;

use Xyu\TtApp\Contract\AbstractGateway;

class PreparceCode extends AbstractGateway
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
                'access-token' => $this->app->client_token->getToken()
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
                'access-token' => $this->app->client_token->getToken()
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
                'access-token' => $this->app->client_token->getToken()
            ],
            \GuzzleHttp\RequestOptions::JSON => [
                'code_list' => $params['code'],
                'open_id' => $params['openid'],
                'order_ext_id' => $params['order_ext_id'], // 接入方订单ID
            ]
        ])->getBody();

        return json_decode((string)$result, true) ?: $result;
    }

    /**
     * 验券准备
     * @param string|null $code
     * @param string|null $encrypted_data
     * @return mixed|\Psr\Http\Message\StreamInterface
     */
    public function verifyCodePrepare(?string $code = null, ?string $encrypted_data = null)
    {
        $result = $this->app->http->request('GET','https://open.douyin.com/goodlife/v1/fulfilment/certificate/prepare', [
            \GuzzleHttp\RequestOptions::HEADERS => [
                'access-token' => $this->app->client_token->getToken()
            ],
            \GuzzleHttp\RequestOptions::QUERY => [
                'encrypted_data' => $encrypted_data,
                'code' => $code,
            ]
        ])->getBody();

        return json_decode((string)$result, true) ?: $result;
    }

    /**
     * 验券
     * @param array $params
     * @return mixed|\Psr\Http\Message\StreamInterface
     */
    public function verifyCode(array $params)
    {
        $result = $this->app->http->request('POST','https://open.douyin.com/goodlife/v1/fulfilment/certificate/verify', [
            \GuzzleHttp\RequestOptions::HEADERS => [
                'Content-Type' => 'application/json',
                'access-token' => $this->app->client_token->getToken()
            ],
            \GuzzleHttp\RequestOptions::JSON => $params
        ])->getBody();

        return json_decode((string)$result, true) ?: $result;
    }

    /**
     * 撤销核销
     * @param array $params
     * @return mixed|\Psr\Http\Message\StreamInterface
     */
    public function cancelCode(array $params)
    {
        $result = $this->app->http->request('POST','https://open.douyin.com/goodlife/v1/fulfilment/certificate/cancel', [
            \GuzzleHttp\RequestOptions::HEADERS => [
                'Content-Type' => 'application/json',
                'access-token' => $this->app->client_token->getToken()
            ],
            \GuzzleHttp\RequestOptions::JSON => [
                'verify_id' => $params['verify_id'],
                'certificate_id' => $params['certificate_id'],
            ]
        ])->getBody();

        return json_decode((string)$result, true) ?: $result;
    }

    /**
     * 券状态查询
     * @param string|null $codes
     * @param string|null $order_id
     * @param string|null $encrypted_code
     * @return mixed|\Psr\Http\Message\StreamInterface
     */
    public function codeStatus(?string $codes = null, ?string $order_id = null, ?string $encrypted_code = null)
    {
        $result = $this->app->http->request('GET','https://open.douyin.com/goodlife/v1/fulfilment/certificate/get', [
            \GuzzleHttp\RequestOptions::HEADERS => [
                'access-token' => $this->app->client_token->getToken()
            ],
            \GuzzleHttp\RequestOptions::QUERY => [
                'encrypted_code' => $encrypted_code,
                'codes' => $codes,
                'order_id' => $order_id,
            ]
        ])->getBody();

        return json_decode((string)$result, true) ?: $result;
    }

    /**
     * 验券历史查询
     * @param array $params
     * @return mixed|\Psr\Http\Message\StreamInterface
     */
    public function verifyCodeRecord(array $params)
    {
        $result = $this->app->http->request('GET','https://open.douyin.com/goodlife/v1/fulfilment/certificate/verify_record/query', [
            \GuzzleHttp\RequestOptions::HEADERS => [
                'access-token' => $this->app->client_token->getToken()
            ],
            \GuzzleHttp\RequestOptions::QUERY => $params
        ])->getBody();

        return json_decode((string)$result, true) ?: $result;
    }

    /**
     * 分账明细查询
     * @param string $certificate_ids
     * @return mixed|\Psr\Http\Message\StreamInterface
     */
    public function billCodeQuery(string $certificate_ids)
    {
        $result = $this->app->http->request('GET','https://open.douyin.com/goodlife/v1/settle/ledger/query_record_by_cert', [
            \GuzzleHttp\RequestOptions::HEADERS => [
                'access-token' => $this->app->client_token->getToken()
            ],
            \GuzzleHttp\RequestOptions::QUERY => [
                'certificate_ids' => $certificate_ids
            ]
        ])->getBody();

        return json_decode((string)$result, true) ?: $result;
    }

}