<?php

namespace Xyu\TtApp\Douyin\KA;

use Xyu\TtApp\Contract\AbstractGateway;
use Xyu\TtApp\Exception\KaBusinessException;

class KaOrder extends AbstractGateway
{
    /**
     * 预下单 交易回调设置接口
     * @param string $create_order_callback
     * @param string $refund_callback
     * @param string|null $delivery_qrcode_redirect
     * @param string|null $book_callback
     * @return mixed|\Psr\Http\Message\StreamInterface
     * @throws KaBusinessException
     */
    public function tradeSettings(string $create_order_callback, string $refund_callback,
                                  ?string $delivery_qrcode_redirect = null, ?string $book_callback = null)
    {
        $body = compact('create_order_callback','refund_callback', 'delivery_qrcode_redirect', 'book_callback');

        $sign = $this->kaSign('/api/apps/trade/v2/settings', json_encode($body));

        $result = $this->app->http
            ->request('POST','https://developer.toutiao.com/api/apps/trade/v2/settings', [
                \GuzzleHttp\RequestOptions::HEADERS => [
                    'Content-Type' => 'application/json',
                    'Byte-Authorization' => 'SHA256-RSA2048 ' .
                        'appid='. $this->app->getAppId() .
                        ',nonce_str=' . $this->nonceStr .
                        ',timestamp=' . $this->timestamp .
                        ',key_version=1' .
                        ',signature=' . $sign
                ],
                \GuzzleHttp\RequestOptions::JSON => $body
            ])->getBody();

        return json_decode((string)$result, true) ?: $result;
    }

    /**
     * 预下单 查询交易回调设置接口
     * @param string $create_order_callback
     * @param string $refund_callback
     * @param string|null $delivery_qrcode_redirect
     * @param string|null $book_callback
     * @param string|null $query_marketing_callback
     * @param string|null $calculation_callback
     * @return mixed|\Psr\Http\Message\StreamInterface
     * @throws KaBusinessException
     */
    public function tradeQuerySettings(string $create_order_callback, string $refund_callback,
                                       ?string $delivery_qrcode_redirect = null, ?string $book_callback = null,
                                       ?string $query_marketing_callback = null, ?string $calculation_callback = null)
    {
        $body = compact(
            'create_order_callback',
            'refund_callback',
            'delivery_qrcode_redirect',
            'book_callback',
            'calculation_callback',
            'query_marketing_callback',
        );

        $sign = $this->kaSign('/api/apps/trade/v2/query_settings', json_encode($body));

        $result = $this->app->http
            ->request('POST','https://developer.toutiao.com/api/apps/trade/v2/query_settings', [
                \GuzzleHttp\RequestOptions::HEADERS => [
                    'Content-Type' => 'application/json',
                    'Byte-Authorization' => 'SHA256-RSA2048 ' .
                        'appid='. $this->app->getAppId() .
                        ',nonce_str=' . $this->nonceStr .
                        ',timestamp=' . $this->timestamp .
                        ',key_version=1' .
                        ',signature=' . $sign
                ],
                \GuzzleHttp\RequestOptions::JSON => $body
            ])->getBody();

        return json_decode((string)$result, true) ?: $result;
    }

    /**
     * 订单信息接口
     * @param string|null $order_id
     * @param string|null $out_order_no
     * @return mixed|\Psr\Http\Message\StreamInterface
     * @throws KaBusinessException
     */
    public function tradeQueryOrder(?string $order_id = null, ?string $out_order_no = null)
    {
        $body = compact(
            'order_id',
            'out_order_no'
        );
        $sign = $this->kaSign('/api/apps/trade/v2/query_order', json_encode($body));

        $result = $this->app->http
            ->request('POST','https://developer.toutiao.com/api/apps/trade/v2/query_order', [
                \GuzzleHttp\RequestOptions::HEADERS => [
                    'Content-Type' => 'application/json',
                    'Byte-Authorization' => 'SHA256-RSA2048 ' .
                        'appid='. $this->app->getAppId() .
                        ',nonce_str=' . $this->nonceStr .
                        ',timestamp=' . $this->timestamp .
                        ',key_version=1' .
                        ',signature=' . $sign
                ],
                \GuzzleHttp\RequestOptions::JSON => $body
            ])->getBody();

        return json_decode((string)$result, true) ?: $result;
    }

    /**
     * 查询CPS订单信息接口
     * @param string|null $order_id
     * @param string|null $out_order_no
     * @return mixed|\Psr\Http\Message\StreamInterface
     * @throws KaBusinessException
     */
    public function tradeQueryCps(?string $order_id = null, ?string $out_order_no = null)
    {
        $body = compact(
            'order_id',
            'out_order_no'
        );
        $sign = $this->kaSign('/api/apps/trade/v2/query_cps', json_encode($body));

        $result = $this->app->http
            ->request('POST','https://developer.toutiao.com/api/apps/trade/v2/query_cps', [
                \GuzzleHttp\RequestOptions::HEADERS => [
                    'Content-Type' => 'application/json',
                    'Byte-Authorization' => 'SHA256-RSA2048 ' .
                        'appid='. $this->app->getAppId() .
                        ',nonce_str=' . $this->nonceStr .
                        ',timestamp=' . $this->timestamp .
                        ',key_version=1' .
                        ',signature=' . $sign
                ],
                \GuzzleHttp\RequestOptions::JSON => $body
            ])->getBody();

        return json_decode((string)$result, true) ?: $result;
    }

    /**
     * 推送核销状态 非闭环
     * @param string $out_order_no
     * @param array|null $item_order_list
     * @param bool|null $use_all
     * @param string|null $poi_info
     * @return mixed|\Psr\Http\Message\StreamInterface
     * @throws KaBusinessException
     */
    public function tradePushDelivery(string $out_order_no, ?array $item_order_list = null,
                                      bool $use_all = null, ?string $poi_info = null)
    {
        $body = compact(
            'out_order_no',
            'item_order_list',
            'use_all',
            'poi_info',
        );
        $sign = $this->kaSign('/api/apps/trade/v2/push_delivery', json_encode($body));

        $result = $this->app->http
            ->request('POST','https://developer.toutiao.com/api/apps/trade/v2/push_delivery', [
                \GuzzleHttp\RequestOptions::HEADERS => [
                    'Content-Type' => 'application/json',
                    'Byte-Authorization' => 'SHA256-RSA2048 ' .
                        'appid='. $this->app->getAppId() .
                        ',nonce_str=' . $this->nonceStr .
                        ',timestamp=' . $this->timestamp .
                        ',key_version=1' .
                        ',signature=' . $sign
                ],
                \GuzzleHttp\RequestOptions::JSON => $body
            ])->getBody();

        return json_decode((string)$result, true) ?: $result;
    }

    /**
     * 分账发起
     * @param string $out_order_no
     * @param string $out_settle_no
     * @param string $settle_desc
     * @param string|null $settle_params
     * @param string|null $cp_extra
     * @param string|null $notify_url
     * @return mixed|\Psr\Http\Message\StreamInterface
     * @throws KaBusinessException
     */
    public function tradeCreateSettle(string $out_order_no, string $out_settle_no,
                                      string $settle_desc, ?string $settle_params = null,
                                      ?string $cp_extra = null, ?string $notify_url = null)
    {
        $body = compact(
            'out_order_no',
            'out_settle_no',
            'settle_desc',
            'settle_params',
            'cp_extra',
            'notify_url',
        );
        $sign = $this->kaSign('/api/apps/trade/v2/create_settle', json_encode($body));

        $result = $this->app->http
            ->request('POST','https://developer.toutiao.com/api/apps/trade/v2/create_settle', [
                \GuzzleHttp\RequestOptions::HEADERS => [
                    'Content-Type' => 'application/json',
                    'Byte-Authorization' => 'SHA256-RSA2048 ' .
                        'appid='. $this->app->getAppId() .
                        ',nonce_str=' . $this->nonceStr .
                        ',timestamp=' . $this->timestamp .
                        ',key_version=1' .
                        ',signature=' . $sign
                ],
                \GuzzleHttp\RequestOptions::JSON => $body
            ])->getBody();

        return json_decode((string)$result, true) ?: $result;
    }

    /**
     * 查询分账
     * @param string|null $out_order_no
     * @param string|null $out_settle_no
     * @param string|null $order_id
     * @param string|null $settle_id
     * @return mixed|\Psr\Http\Message\StreamInterface
     * @throws KaBusinessException
     */
    public function tradeQuerySettle(?string $out_order_no = null, ?string $out_settle_no = null,
                                     ?string $order_id = null, ?string $settle_id = null)
    {
        $body = compact(
            'out_order_no',
            'out_settle_no',
            'order_id',
            'settle_id'
        );
        $sign = $this->kaSign('/api/apps/trade/v2/query_settle', json_encode($body));

        $result = $this->app->http
            ->request('POST','https://developer.toutiao.com/api/apps/trade/v2/query_settle', [
                \GuzzleHttp\RequestOptions::HEADERS => [
                    'Content-Type' => 'application/json',
                    'Byte-Authorization' => 'SHA256-RSA2048 ' .
                        'appid='. $this->app->getAppId() .
                        ',nonce_str=' . $this->nonceStr .
                        ',timestamp=' . $this->timestamp .
                        ',key_version=1' .
                        ',signature=' . $sign
                ],
                \GuzzleHttp\RequestOptions::JSON => $body
            ])->getBody();

        return json_decode((string)$result, true) ?: $result;
    }

    /**
     * 退款发起
     * @param array $params
     * @return mixed|\Psr\Http\Message\StreamInterface
     * @throws KaBusinessException
     */
    public function createRefund(array $params)
    {

        $sign = $this->kaSign('/api/apps/trade/v2/create_refund', json_encode($params));

        $result = $this->app->http
            ->request('POST','https://developer.toutiao.com/api/apps/trade/v2/create_refund', [
                \GuzzleHttp\RequestOptions::HEADERS => [
                    'Content-Type' => 'application/json',
                    'Byte-Authorization' => 'SHA256-RSA2048 ' .
                        'appid='. $this->app->getAppId() .
                        ',nonce_str=' . $this->nonceStr .
                        ',timestamp=' . $this->timestamp .
                        ',key_version=1' .
                        ',signature=' . $sign
                ],
                \GuzzleHttp\RequestOptions::JSON => $params
            ])->getBody();

        return json_decode((string)$result, true) ?: $result;
    }

    /**
     * 退款审核结果同步
     * @param string $out_refund_no
     * @param int $refund_audit_status
     * @param string|null $deny_message
     * @return mixed|\Psr\Http\Message\StreamInterface
     * @throws KaBusinessException
     */
    public function merchantAuditCallback(string $out_refund_no, int $refund_audit_status, ?string $deny_message = null)
    {
        $body = compact(
            'out_refund_no',
            'refund_audit_status',
            'deny_message'
        );
        $sign = $this->kaSign('/api/apps/trade/v2/merchant_audit_callback', json_encode($body));

        $result = $this->app->http
            ->request('POST','https://developer.toutiao.com/api/apps/trade/v2/merchant_audit_callback', [
                \GuzzleHttp\RequestOptions::HEADERS => [
                    'Content-Type' => 'application/json',
                    'Byte-Authorization' => 'SHA256-RSA2048 ' .
                        'appid='. $this->app->getAppId() .
                        ',nonce_str=' . $this->nonceStr .
                        ',timestamp=' . $this->timestamp .
                        ',key_version=1' .
                        ',signature=' . $sign
                ],
                \GuzzleHttp\RequestOptions::JSON => $body
            ])->getBody();

        return json_decode((string)$result, true) ?: $result;
    }

    /**
     * 查询退款接口
     * @param string|null $refund_id
     * @param string|null $out_refund_no
     * @return mixed|\Psr\Http\Message\StreamInterface
     * @throws KaBusinessException
     */
    public function queryRefund(?string $refund_id = null, ?string $out_refund_no = null)
    {
        $body = compact(
            'refund_id',
            'out_refund_no'
        );
        $sign = $this->kaSign('/api/apps/trade/v2/query_refund', json_encode($body));

        $result = $this->app->http
            ->request('POST','https://developer.toutiao.com/api/apps/trade/v2/query_refund', [
                \GuzzleHttp\RequestOptions::HEADERS => [
                    'Content-Type' => 'application/json',
                    'Byte-Authorization' => 'SHA256-RSA2048 ' .
                        'appid='. $this->app->getAppId() .
                        ',nonce_str=' . $this->nonceStr .
                        ',timestamp=' . $this->timestamp .
                        ',key_version=1' .
                        ',signature=' . $sign
                ],
                \GuzzleHttp\RequestOptions::JSON => $body
            ])->getBody();

        return json_decode((string)$result, true) ?: $result;
    }
}