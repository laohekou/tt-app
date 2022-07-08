<?php

namespace Xyu\TtApp\Douyin\LifeService;

use Xyu\TtApp\Contract\AbstractGateway;

class Shops extends AbstractGateway
{

    /**
     * SKU同步
     * @param array $params
     * @param string $spu_ext_id
     * @return mixed|\Psr\Http\Message\StreamInterface
     */
    public function skuSync(array $params, string $spu_ext_id)
    {
        $result = $this->app->http
            ->request('POST','https://open.douyin.com/poi/sku/sync', [
                \GuzzleHttp\RequestOptions::HEADERS => [
                    'Content-Type' => 'application/json',
                    'access-token' => $this->app->client_token->getToken()
                ],
                \GuzzleHttp\RequestOptions::QUERY => [
                    'skus' => $params,
                    'spu_ext_id' => $spu_ext_id
                ]
            ])->getBody();

        return json_decode((string)$result, true) ?: $result;
    }

    /**
     * sku拉取
     * @param array $spu_ext_ids
     * @param $start_date
     * @param $end_date
     * @return mixed|\Psr\Http\Message\StreamInterface
     */
    public function skuQuery(array $spu_ext_ids, $start_date, $end_date)
    {
        $result = $this->app->http
            ->request('GET','https://open.douyin.com/poi/sku/sync', [
                \GuzzleHttp\RequestOptions::HEADERS => [
                    'Content-Type' => 'application/json',
                    'access-token' => $this->app->client_token->getToken()
                ],
                \GuzzleHttp\RequestOptions::QUERY => [
                    'spu_ext_id' => $spu_ext_ids,
                    'start_date' => $start_date,
                    'end_date' => $end_date,
                ]
            ])->getBody();

        return json_decode((string)$result, true) ?: $result;
    }

    /**
     * 多门店 SPU 同步
     * @param array $params
     * @return mixed|\Psr\Http\Message\StreamInterface
     */
    public function spuSync(array $params)
    {
        $result = $this->app->http
            ->request('POST','https://open.douyin.com/poi/v2/spu/sync', [
                \GuzzleHttp\RequestOptions::HEADERS => [
                    'Content-Type' => 'application/json',
                    'access-token' => $this->app->client_token->getToken()
                ],
                \GuzzleHttp\RequestOptions::QUERY => $params
            ])->getBody();

        return json_decode((string)$result, true) ?: $result;
    }

    /**
     * 多门店SPU状态同步
     * @param array $params
     * @param int $status
     * @return mixed|\Psr\Http\Message\StreamInterface
     */
    public function spuStatusSync(array $params, int $status = 1)
    {
        $result = $this->app->http
            ->request('POST','https://open.douyin.com/poi/v2/spu/status_sync', [
                \GuzzleHttp\RequestOptions::HEADERS => [
                    'Content-Type' => 'application/json',
                    'access-token' => $this->app->client_token->getToken()
                ],
                \GuzzleHttp\RequestOptions::QUERY => [
                    'spu_ext_id_list' => $params,
                    'status' => $status
                ]
            ])->getBody();

        return json_decode((string)$result, true) ?: $result;
    }

    /**
     * 多门店SPU库存同步
     * @param string $spu_ext_id
     * @param int $stock
     * @return mixed|\Psr\Http\Message\StreamInterface
     */
    public function spuStockSync(string $spu_ext_id, int $stock)
    {
        $result = $this->app->http
            ->request('POST','https://open.douyin.com/poi/v2/spu/stock_update', [
                \GuzzleHttp\RequestOptions::HEADERS => [
                    'Content-Type' => 'application/json',
                    'access-token' => $this->app->client_token->getToken()
                ],
                \GuzzleHttp\RequestOptions::QUERY => [
                    'spu_ext_id' => $spu_ext_id,
                    'stock' => $stock
                ]
            ])->getBody();

        return json_decode((string)$result, true) ?: $result;
    }

    /**
     * 多门店 SPU 信息查询
     * @param string $spu_ext_id
     * @param bool $need_spu_draft
     * @param int|null $spu_draft_count
     * @param array|null $supplier_ids_for_filter_reason
     * @return mixed|\Psr\Http\Message\StreamInterface
     */
    public function spuInfo(string $spu_ext_id, bool $need_spu_draft, ?int $spu_draft_count = null, ?array $supplier_ids_for_filter_reason = null)
    {
        $result = $this->app->http
            ->request('GET','https://open.douyin.com/poi/v2/spu/get', [
                \GuzzleHttp\RequestOptions::HEADERS => [
                    'Content-Type' => 'application/json',
                    'access-token' => $this->app->client_token->getToken()
                ],
                \GuzzleHttp\RequestOptions::QUERY => [
                    'spu_ext_id' => $spu_ext_id,
                    'need_spu_draft' => $need_spu_draft,
                    'spu_draft_count' => $spu_draft_count,
                    'supplier_ids_for_filter_reason' => $supplier_ids_for_filter_reason,
                ]
            ])->getBody();

        return json_decode((string)$result, true) ?: $result;
    }

    /**
     * 商品达人分佣配置
     * @param int $status
     * @param int $take_rate
     * @param string $douyin_id
     * @param string $spu_ext_id
     * @return mixed|\Psr\Http\Message\StreamInterface
     */
    public function spuTakeRateSync(int $status, int $take_rate, string $douyin_id, string $spu_ext_id)
    {
        $result = $this->app->http
            ->request('POST','https://open.douyin.com/poi/v2/spu/take_rate/sync', [
                \GuzzleHttp\RequestOptions::HEADERS => [
                    'Content-Type' => 'application/json',
                    'access-token' => $this->app->client_token->getToken()
                ],
                \GuzzleHttp\RequestOptions::QUERY => [
                    'status' => $status,
                    'take_rate' => $take_rate,
                    'douyin_id' => $douyin_id,
                    'spu_ext_id' => $spu_ext_id,
                ]
            ])->getBody();

        return json_decode((string)$result, true) ?: $result;
    }


    /**
     * 商铺同步
     * @param array $params
     * @return mixed|\Psr\Http\Message\StreamInterface
     */
    public function shopsSync(array $params)
    {
        $result = $this->app->http
            ->request('POST','https://open.douyin.com/poi/supplier/sync', [
                \GuzzleHttp\RequestOptions::HEADERS => [
                    'Content-Type' => 'application/json',
                    'access-token' => $this->app->client_token->getToken()
                ],
                \GuzzleHttp\RequestOptions::QUERY => $params
            ])->getBody();

        return json_decode((string)$result, true) ?: $result;
    }

    /**
     * 查询店铺
     * @param string $supplier_ext_id
     * @return mixed|\Psr\Http\Message\StreamInterface
     */
    public function queryShop(string $supplier_ext_id)
    {
        $result = $this->app->http
            ->request('GET','https://open.douyin.com/poi/supplier/query', [
                \GuzzleHttp\RequestOptions::HEADERS => [
                    'Content-Type' => 'application/json',
                    'access-token' => $this->app->client_token->getToken()
                ],
                \GuzzleHttp\RequestOptions::QUERY => [
                    'supplier_ext_id' => $supplier_ext_id
                ]
            ])->getBody();

        return json_decode((string)$result, true) ?: $result;
    }

    /**
     * 店铺匹配任务结果查询
     * @param string $supplier_task_ids
     * @return mixed|\Psr\Http\Message\StreamInterface
     */
    public function queryTask(string $supplier_task_ids)
    {
        $result = $this->app->http
            ->request('GET','https://open.douyin.com/poi/v2/supplier/query/task', [
                \GuzzleHttp\RequestOptions::HEADERS => [
                    'Content-Type' => 'application/json',
                    'access-token' => $this->app->client_token->getToken()
                ],
                \GuzzleHttp\RequestOptions::QUERY => [
                    'supplier_task_ids' => $supplier_task_ids
                ]
            ])->getBody();

        return json_decode((string)$result, true) ?: $result;
    }

    /**
     * 店铺匹配状态查询
     * @param string $supplier_ext_id
     * @return mixed|\Psr\Http\Message\StreamInterface
     */
    public function queryStatus(string $supplier_ext_id)
    {
        $result = $this->app->http
            ->request('GET','https://open.douyin.com/poi/v2/supplier/query/supplier', [
                \GuzzleHttp\RequestOptions::HEADERS => [
                    'Content-Type' => 'application/json',
                    'access-token' => $this->app->client_token->getToken()
                ],
                \GuzzleHttp\RequestOptions::QUERY => [
                    'supplier_ext_id' => $supplier_ext_id
                ]
            ])->getBody();

        return json_decode((string)$result, true) ?: $result;
    }

    /**
     * 发起店铺匹配 POI 同步任务
     * @param array $params
     * @return mixed|\Psr\Http\Message\StreamInterface
     */
    public function matchTask(array $params)
    {
        $result = $this->app->http
            ->request('POST','https://open.douyin.com/poi/v2/supplier/match', [
                \GuzzleHttp\RequestOptions::HEADERS => [
                    'Content-Type' => 'application/json',
                    'access-token' => $this->app->client_token->getToken()
                ],
                \GuzzleHttp\RequestOptions::QUERY => [
                    'match_data_list' => $params
                ]
            ])->getBody();

        return json_decode((string)$result, true) ?: $result;
    }

    /**
     * 查询全部店铺信息接口
     * @return mixed|\Psr\Http\Message\StreamInterface
     */
    public function queryAll()
    {
        $result = $this->app->http
            ->request('POST','https://open.douyin.com/poi/supplier/query_all', [
                \GuzzleHttp\RequestOptions::HEADERS => [
                    'Content-Type' => 'application/json',
                    'access-token' => $this->app->client_token->getToken()
                ],
                \GuzzleHttp\RequestOptions::QUERY => []
            ])->getBody();

        return json_decode((string)$result, true) ?: $result;
    }

    /**
     * 查询店铺全部信息任务返回内容
     * @param string $task_id
     * @return mixed|\Psr\Http\Message\StreamInterface
     */
    public function queryAllCallback(string $task_id)
    {
        $result = $this->app->http
            ->request('GET','https://open.douyin.com/poi/supplier/query_callback', [
                \GuzzleHttp\RequestOptions::HEADERS => [
                    'Content-Type' => 'application/json',
                    'access-token' => $this->app->client_token->getToken()
                ],
                \GuzzleHttp\RequestOptions::QUERY => [
                    'task_id' => $task_id
                ]
            ])->getBody();

        return json_decode((string)$result, true) ?: $result;
    }

    /**
     * 门店信息查询
     * @param int $page
     * @param int $size
     * @return mixed|\Psr\Http\Message\StreamInterface
     */
    public function poiQuery(int $page = 1, int $size = 20)
    {
        $result = $this->app->http
            ->request('GET','https://open.douyin.com/goodlife/v1/shop/poi/query', [
                \GuzzleHttp\RequestOptions::HEADERS => [
                    'Content-Type' => 'application/json',
                    'access-token' => $this->app->client_token->getToken()
                ],
                \GuzzleHttp\RequestOptions::QUERY => [
                    'page' => $page,
                    'size' => $size,
                ]
            ])->getBody();

        return json_decode((string)$result, true) ?: $result;
    }
}