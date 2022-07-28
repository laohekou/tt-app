<?php

namespace Xyu\TtApp\Douyin\KA;

use Xyu\TtApp\Contract\AbstractGateway;

class Goods extends AbstractGateway
{
    /**
     * 查询商品模版
     * @param int $category_id
     * @param int $product_type
     * @return mixed|\Psr\Http\Message\StreamInterface
     */
    public function goodsTemplate(int $category_id, int $product_type)
    {
        $result = $this->app->http
            ->request('GET','https://open.douyin.com/life/goods/template/get/', [
                \GuzzleHttp\RequestOptions::QUERY => [
                    'access_token' => $this->app->client_token->getToken(),
                    'product_type' => $product_type,
                    'category_id' => $category_id
                ]
            ])->getBody();

        return json_decode((string)$result, true) ?: $result;
    }

    /**
     * 查询商品草稿数据
     * @param string|null $out_ids
     * @param string|null $product_ids
     * @return mixed|\Psr\Http\Message\StreamInterface
     */
    public function goodsProductDraft(?string $out_ids = null, ?string $product_ids = null)
    {
        $result = $this->app->http
            ->request('GET','https://open.douyin.com/life/goods/product/draft/get/', [
                \GuzzleHttp\RequestOptions::QUERY => [
                    'access_token' => $this->app->client_token->getToken(),
                    'out_ids' => $out_ids,
                    'product_ids' => $product_ids
                ]
            ])->getBody();

        return json_decode((string)$result, true) ?: $result;
    }

    /**
     * 查询商品草稿数据列表
     * @param string|null $cursor
     * @param int|null $count
     * @param int|null $status
     * @return mixed|\Psr\Http\Message\StreamInterface
     */
    public function goodsProductDraftList(string $cursor = null, int $count = null, int $status = null)
    {
        $result = $this->app->http
            ->request('GET','https://open.douyin.com/life/goods/product/draft/list/', [
                \GuzzleHttp\RequestOptions::QUERY => [
                    'access_token' => $this->app->client_token->getToken(),
                    'status' => $status,
                    'count' => $count,
                    'cursor' => $cursor,
                ]
            ])->getBody();

        return json_decode((string)$result, true) ?: $result;
    }

    /**
     * 查询商品线上数据
     * @param string|null $product_ids
     * @param string|null $out_ids
     * @return mixed|\Psr\Http\Message\StreamInterface
     */
    public function goodsProductOnline(string $product_ids = null, string $out_ids = null)
    {
        $result = $this->app->http
            ->request('GET','https://open.douyin.com/life/goods/product/online/get/', [
                \GuzzleHttp\RequestOptions::QUERY => [
                    'access_token' => $this->app->client_token->getToken(),
                    'product_ids' => $product_ids,
                    'out_ids' => $out_ids,
                ]
            ])->getBody();

        return json_decode((string)$result, true) ?: $result;
    }

    /**
     * 查询商品线上数据列表
     * @param string|null $cursor
     * @param int|null $count
     * @param int|null $status
     * @return mixed|\Psr\Http\Message\StreamInterface
     */
    public function goodsProductOnlineList(string $cursor = null, int $count = null, int $status = null)
    {
        $result = $this->app->http
            ->request('GET','https://open.douyin.com/life/goods/product/online/list/', [
                \GuzzleHttp\RequestOptions::QUERY => [
                    'access_token' => $this->app->client_token->getToken(),
                    'status' => $status,
                    'count' => $count,
                    'cursor' => $cursor,
                ]
            ])->getBody();

        return json_decode((string)$result, true) ?: $result;
    }

    /**
     * 创建/更新商品
     * @param array $params
     * @return mixed|\Psr\Http\Message\StreamInterface
     */
    public function goodsProductSave(array $params)
    {
        $result = $this->app->http
            ->request('POST','https://open.douyin.com/life/goods/product/save/?access_token=' . $this->app->client_token->getToken(), [
                \GuzzleHttp\RequestOptions::HEADERS => [
                    'Content-Type' => 'application/json',
                ],
                \GuzzleHttp\RequestOptions::QUERY => $params
            ])->getBody();

        return json_decode((string)$result, true) ?: $result;
    }

    /**
     * 免审修改团购活动
     * @param string $product_id
     * @param string $out_id
     * @param int|null $sold_end_time
     * @param int|null $stock_qty
     * @param string|null $owner_account_id
     * @return mixed|\Psr\Http\Message\StreamInterface
     */
    public function goodsProductFreeAudit(string $product_id, string $out_id,
                                          int $sold_end_time = null, int $stock_qty = null, string $owner_account_id = null)
    {
        $params = compact(
            'product_id',
            'out_id',
            'sold_end_time',
            'stock_qty',
            'owner_account_id',
        );

        $result = $this->app->http
            ->request('POST','https://open.douyin.com/life/goods/product/free_audit/?access_token=' . $this->app->client_token->getToken(), [
                \GuzzleHttp\RequestOptions::HEADERS => [
                    'Content-Type' => 'application/json',
                ],
                \GuzzleHttp\RequestOptions::QUERY => $params
            ])->getBody();

        return json_decode((string)$result, true) ?: $result;
    }

    /**
     * 创建/更新多SKU商品的SKU列表（团购/代金券不用对接这个接口）
     * @param array $params
     * @return mixed|\Psr\Http\Message\StreamInterface
     */
    public function goodsSkuBatchSave(array $params)
    {
        $result = $this->app->http
            ->request('POST','https://open.douyin.com/life/goods/sku/batch_save/?access_token=' . $this->app->client_token->getToken(), [
                \GuzzleHttp\RequestOptions::HEADERS => [
                    'Content-Type' => 'application/json',
                ],
                \GuzzleHttp\RequestOptions::QUERY => $params
            ])->getBody();

        return json_decode((string)$result, true) ?: $result;
    }

    /**
     * 上下架商品
     * @param int $op_type
     * @param string|null $product_id
     * @param string|null $out_id
     * @return mixed|\Psr\Http\Message\StreamInterface
     */
    public function goodsProductOperate(int $op_type, string $product_id = null, string $out_id = null)
    {
        $params = compact(
            'op_type',
            'product_id',
            'out_id',
        );

        $result = $this->app->http
            ->request('POST','https://open.douyin.com/life/goods/product/operate/?access_token=' . $this->app->client_token->getToken(), [
                \GuzzleHttp\RequestOptions::HEADERS => [
                    'Content-Type' => 'application/json',
                ],
                \GuzzleHttp\RequestOptions::QUERY => $params
            ])->getBody();

        return json_decode((string)$result, true) ?: $result;
    }

    /**
     * 同步库存
     * @param string $product_id
     * @param string $out_id
     * @param int $limit_type
     * @param int $stock_qty
     * @return mixed|\Psr\Http\Message\StreamInterface
     */
    public function goodsStockSync(string $product_id, string $out_id, int $limit_type, int $stock_qty)
    {
        $result = $this->app->http
            ->request('POST','https://open.douyin.com/life/goods/stock/sync/?access_token=' . $this->app->client_token->getToken(), [
                \GuzzleHttp\RequestOptions::HEADERS => [
                    'Content-Type' => 'application/json',
                ],
                \GuzzleHttp\RequestOptions::QUERY => [
                    'product_id' => $product_id,
                    'out_id' => $out_id,
                    'stock' => [
                        'limit_type' => $limit_type,
                        'stock_qty' => $stock_qty,
                    ],
                ]
            ])->getBody();

        return json_decode((string)$result, true) ?: $result;
    }

    /**
     * 查询商品行业类目
     * @param int|null $category_id
     * @param int|null $account_id
     * @return mixed|\Psr\Http\Message\StreamInterface
     */
    public function goodsCategoryGet(int $category_id = null, int $account_id = null)
    {
        $result = $this->app->http
            ->request('GET','https://open.douyin.com/life/goods/category/get/', [
                \GuzzleHttp\RequestOptions::QUERY => [
                    'access_token' => $this->app->client_token->getToken(),
                    'category_id' => $category_id,
                    'account_id' => $account_id,
                ]
            ])->getBody();

        return json_decode((string)$result, true) ?: $result;
    }
}