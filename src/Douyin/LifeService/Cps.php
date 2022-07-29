<?php

namespace Xyu\TtApp\Douyin\LifeService;

use Xyu\TtApp\Contract\AbstractGateway;

class Cps extends AbstractGateway
{
    /**
     * 修改通用佣金计划状态
     * @param array $plan_update_list
     * @param int $plan_id
     * @param int $status
     * @return mixed|\Psr\Http\Message\StreamInterface
     */
    public function planStatus(array $plan_update_list, int $plan_id, int $status)
    {
        $result = $this->app->http
            ->request('POST','https://open.douyin.com/poi/common/plan/update/status/', [
                \GuzzleHttp\RequestOptions::HEADERS => [
                    'Content-Type' => 'application/json',
                    'access-token' => $this->app->client_token->get_lock_token()
                ],
                \GuzzleHttp\RequestOptions::JSON => [
                    'plan_update_list' => $plan_update_list,
                    'plan_id' => $plan_id,
                    'status' => $status
                ]
            ])->getBody();

        return json_decode((string)$result, true) ?: $result;
    }

    /**
     * 查询通用佣金计划
     * @param int $spu_id
     * @param int $page_no
     * @param int $page_size
     * @return mixed|\Psr\Http\Message\StreamInterface
     */
    public function planList(int $spu_id, int $page_no = 1, int $page_size = 20)
    {
        $result = $this->app->http
            ->request('POST','https://open.douyin.com/poi/plan/list', [
                \GuzzleHttp\RequestOptions::HEADERS => [
                    'Content-Type' => 'application/json',
                    'access-token' => $this->app->client_token->get_lock_token()
                ],
                \GuzzleHttp\RequestOptions::JSON => [
                    'spu_id' => $spu_id,
                    'page_no' => $page_no,
                    'page_size' => $page_size
                ]
            ])->getBody();

        return json_decode((string)$result, true) ?: $result;
    }

    /**
     * 通用佣金计划查询带货数据
     * @param array $plan_id_list
     * @return mixed|\Psr\Http\Message\StreamInterface
     */
    public function planDetail(array $plan_id_list)
    {
        $result = $this->app->http
            ->request('POST','https://open.douyin.com/poi/common/plan/detail', [
                \GuzzleHttp\RequestOptions::HEADERS => [
                    'Content-Type' => 'application/json',
                    'access-token' => $this->app->client_token->get_lock_token()
                ],
                \GuzzleHttp\RequestOptions::JSON => [
                    'plan_id_list' => $plan_id_list
                ]
            ])->getBody();

        return json_decode((string)$result, true) ?: $result;
    }

    /**
     * 通用佣金计划查询带货达人列表
     * @param int $plan_id
     * @param int $page_no
     * @param int $page_size
     * @return mixed|\Psr\Http\Message\StreamInterface
     */
    public function planTalentList(int $plan_id, int $page_no = 1, int $page_size = 20)
    {
        $result = $this->app->http
            ->request('POST','https://open.douyin.com/poi/common/plan/talent/list', [
                \GuzzleHttp\RequestOptions::HEADERS => [
                    'Content-Type' => 'application/json',
                    'access-token' => $this->app->client_token->get_lock_token()
                ],
                \GuzzleHttp\RequestOptions::JSON => [
                    'plan_id' => $plan_id,
                    'page_no' => $page_no,
                    'page_size' => $page_size
                ]
            ])->getBody();

        return json_decode((string)$result, true) ?: $result;
    }

    /**
     * 通用佣金计划查询达人带货数据
     * @param int $plan_id
     * @param array $douyin_id_list
     * @return mixed|\Psr\Http\Message\StreamInterface
     */
    public function planTalentDetail(int $plan_id, array $douyin_id_list)
    {
        $result = $this->app->http
            ->request('POST','https://open.douyin.com/poi/common/plan/talent/detail', [
                \GuzzleHttp\RequestOptions::HEADERS => [
                    'Content-Type' => 'application/json',
                    'access-token' => $this->app->client_token->get_lock_token()
                ],
                \GuzzleHttp\RequestOptions::JSON => [
                    'plan_id' => $plan_id,
                    'douyin_id_list' => $douyin_id_list
                ]
            ])->getBody();

        return json_decode((string)$result, true) ?: $result;
    }

    /**
     * 通用佣金计划查询达人带货详情
     * @param int $plan_id
     * @param string $douyin_id
     * @param int $content_type
     * @param int $page_no
     * @param int $page_size
     * @return mixed|\Psr\Http\Message\StreamInterface
     */
    public function planTalentMediaList(int $plan_id, string $douyin_id, int $content_type = 1, int $page_no = 1, int $page_size = 20)
    {
        $result = $this->app->http
            ->request('POST','https://open.douyin.com/poi/common/plan/talent/media/list', [
                \GuzzleHttp\RequestOptions::HEADERS => [
                    'Content-Type' => 'application/json',
                    'access-token' => $this->app->client_token->get_lock_token()
                ],
                \GuzzleHttp\RequestOptions::JSON => [
                    'plan_id' => $plan_id,
                    'page_no' => $page_no,
                    'page_size' => $page_size,
                    'douyin_id' => $douyin_id,
                    'content_type' => $content_type
                ]
            ])->getBody();

        return json_decode((string)$result, true) ?: $result;
    }

    /**
     * 发布/修改通用佣金计划
     * @param int $plan_id
     * @param int $spu_id
     * @param int $commission_rate
     * @param int $content_type
     * @return mixed|\Psr\Http\Message\StreamInterface
     */
    public function planCommonSave(int $plan_id, int $spu_id, int $commission_rate, int $content_type = 1)
    {
        $result = $this->app->http
            ->request('POST','https://open.douyin.com/poi/common/plan/save', [
                \GuzzleHttp\RequestOptions::HEADERS => [
                    'Content-Type' => 'application/json',
                    'access-token' => $this->app->client_token->get_lock_token()
                ],
                \GuzzleHttp\RequestOptions::JSON => [
                    'plan_id' => $plan_id,
                    'spu_id' => $spu_id,
                    'commission_rate' => $commission_rate,
                    'content_type' => $content_type
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
                    'access-token' => $this->app->client_token->get_lock_token()
                ],
                \GuzzleHttp\RequestOptions::JSON => [
                    'status' => $status,
                    'take_rate' => $take_rate,
                    'douyin_id' => $douyin_id,
                    'spu_ext_id' => $spu_ext_id,
                ]
            ])->getBody();

        return json_decode((string)$result, true) ?: $result;
    }
}