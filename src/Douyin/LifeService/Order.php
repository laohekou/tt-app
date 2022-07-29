<?php

namespace Xyu\TtApp\Douyin\LifeService;

use Xyu\TtApp\Contract\AbstractGateway;

class Order extends AbstractGateway
{
    /**
     * 订单状态同步接口
     * @param int $status
     * @param string $order_id
     * @param string $order_ext_id
     * @param string $supplier_ext_id
     * @return mixed|\Psr\Http\Message\StreamInterface
     */
    public function orderStatus(int $status, string $order_id, string $order_ext_id, string $supplier_ext_id)
    {
        $result = $this->app->http
            ->request('POST','https://open.douyin.com/poi/order/status', [
                \GuzzleHttp\RequestOptions::HEADERS => [
                    'Content-Type' => 'application/json',
                    'access-token' => $this->app->client_token->get_lock_token()
                ],
                \GuzzleHttp\RequestOptions::QUERY => [
                    'status' => $status,
                    'supplier_ext_id' => $supplier_ext_id,
                    'order_ext_id' => $order_ext_id,
                    'order_id' => $order_id,
                ]
            ])->getBody();

        return json_decode((string)$result, true) ?: $result;
    }

    /**
     * 下单接口
     * @param array $params
     * @return mixed|\Psr\Http\Message\StreamInterface
     */
    public function orderCommit(array $params)
    {
        $result = $this->app->http
            ->request('POST','https://open.douyin.com/poi/ext/hotel/order/commit', [
                \GuzzleHttp\RequestOptions::HEADERS => [
                    'Content-Type' => 'application/json',
                    'access-token' => $this->app->douyin_token->get_lock_token()
                ],
                \GuzzleHttp\RequestOptions::QUERY => $params
            ])->getBody();

        return json_decode((string)$result, true) ?: $result;
    }

    /**
     * 支付状态通知
     * @param int $status
     * @param string $order_id
     * @param string $order_ext_id
     * @param string $supplier_ext_id
     * @return mixed|\Psr\Http\Message\StreamInterface
     */
    public function payStatus(int $status, string $order_id, string $order_ext_id, string $supplier_ext_id)
    {
        $result = $this->app->http
            ->request('POST','https://open.douyin.com/poi/ext/hotel/order/status', [
                \GuzzleHttp\RequestOptions::HEADERS => [
                    'Content-Type' => 'application/json',
                    'access-token' => $this->app->douyin_token->get_lock_token()
                ],
                \GuzzleHttp\RequestOptions::QUERY => [
                    'status' => $status,
                    'supplier_ext_id' => $supplier_ext_id,
                    'order_ext_id' => $order_ext_id,
                    'order_id' => $order_id,
                ]
            ])->getBody();

        return json_decode((string)$result, true) ?: $result;
    }

    /**
     * 取消订单
     * @param int $status
     * @param string $order_id
     * @param string $order_ext_id
     * @param string $supplier_ext_id
     * @return mixed|\Psr\Http\Message\StreamInterface
     */
    public function cancelOrder(int $status, string $order_id, string $order_ext_id, string $supplier_ext_id)
    {
        $result = $this->app->http
            ->request('POST','https://open.douyin.com/poi/ext/hotel/order/cancel', [
                \GuzzleHttp\RequestOptions::HEADERS => [
                    'Content-Type' => 'application/json',
                    'access-token' => $this->app->douyin_token->get_lock_token()
                ],
                \GuzzleHttp\RequestOptions::QUERY => [
                    'order_status' => $status,
                    'supplier_ext_id' => $supplier_ext_id,
                    'order_ext_id' => $order_ext_id,
                    'order_id' => $order_id,
                ]
            ])->getBody();

        return json_decode((string)$result, true) ?: $result;
    }

    /**
     * 预售券下单
     * @param array $params
     * @return mixed|\Psr\Http\Message\StreamInterface
     */
    public function presaleGrouponOrderCreate(array $params)
    {
        $result = $this->app->http
            ->request('POST','https://open.douyin.com/poi/ext/presale_groupon/order/create', [
                \GuzzleHttp\RequestOptions::HEADERS => [
                    'Content-Type' => 'application/json',
                    'access-token' => $this->app->douyin_token->get_lock_token()
                ],
                \GuzzleHttp\RequestOptions::QUERY => $params
            ])->getBody();

        return json_decode((string)$result, true) ?: $result;
    }

    /**
     * 预售券确认订单
     * @param string $order_ext_id
     * @return mixed|\Psr\Http\Message\StreamInterface
     */
    public function presaleGrouponOrderCommit(string $order_ext_id)
    {
        $result = $this->app->http
            ->request('POST','https://open.douyin.com/poi/ext/presale_groupon/order/commit', [
                \GuzzleHttp\RequestOptions::HEADERS => [
                    'Content-Type' => 'application/json',
                    'access-token' => $this->app->douyin_token->get_lock_token()
                ],
                \GuzzleHttp\RequestOptions::QUERY => [
                    'order_ext_id' => $order_ext_id
                ]
            ])->getBody();

        return json_decode((string)$result, true) ?: $result;
    }

    /**
     * 预售券取消订单
     * @param array $code_list
     * @param string $order_ext_id
     * @return mixed|\Psr\Http\Message\StreamInterface
     */
    public function presaleGrouponOrderCancel(array $code_list, string $order_ext_id)
    {
        $result = $this->app->http
            ->request('POST','https://open.douyin.com/poi/ext/presale_groupon/order/cancel', [
                \GuzzleHttp\RequestOptions::HEADERS => [
                    'Content-Type' => 'application/json',
                    'access-token' => $this->app->douyin_token->get_lock_token()
                ],
                \GuzzleHttp\RequestOptions::QUERY => [
                    'code_list' => $code_list,
                    'order_ext_id' => $order_ext_id,
                ]
            ])->getBody();

        return json_decode((string)$result, true) ?: $result;
    }

    /**
     * 端内订单同步
     * @param array $params
     * @return mixed|\Psr\Http\Message\StreamInterface
     */
    public function orderSync(array $params)
    {
        $result = $this->app->http
            ->request('POST','https://open.douyin.com/poi/order/sync', [
                \GuzzleHttp\RequestOptions::HEADERS => [
                    'Content-Type' => 'application/json',
                    'access-token' => $this->app->client_token->get_lock_token()
                ],
                \GuzzleHttp\RequestOptions::QUERY => $params
            ])->getBody();

        return json_decode((string)$result, true) ?: $result;
    }

    /**
     * 获取下载账单token
     * @param string $bill_date
     * @return mixed|\Psr\Http\Message\StreamInterface
     */
    public function orderBillToken(string $bill_date)
    {
        $result = $this->app->http
            ->request('GET','https://open.douyin.com/poi/order/bill/token', [
                \GuzzleHttp\RequestOptions::HEADERS => [
                    'Content-Type' => 'application/json',
                    'access-token' => $this->app->client_token->get_lock_token()
                ],
                \GuzzleHttp\RequestOptions::QUERY => [
                    'bill_date' => $bill_date
                ]
            ])->getBody();

        return json_decode((string)$result, true) ?: $result;
    }

    /**
     * 获取下载订单token
     * @param string $order_date
     * @return mixed|\Psr\Http\Message\StreamInterface
     */
    public function orderListToken(string $order_date)
    {
        $result = $this->app->http
            ->request('GET','https://open.douyin.com/poi/order/list/token', [
                \GuzzleHttp\RequestOptions::HEADERS => [
                    'Content-Type' => 'application/json',
                    'access-token' => $this->app->client_token->get_lock_token()
                ],
                \GuzzleHttp\RequestOptions::QUERY => [
                    'order_date' => $order_date
                ]
            ])->getBody();

        return json_decode((string)$result, true) ?: $result;
    }

}