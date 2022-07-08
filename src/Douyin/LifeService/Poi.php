<?php

namespace Xyu\TtApp\Douyin\LifeService;

use Xyu\TtApp\Contract\AbstractGateway;

class Poi extends AbstractGateway
{
    /**
     * 获取POI基础数据
     * @param string $poi_id
     * @param string $begin_date
     * @param string $end_date
     * @return mixed|\Psr\Http\Message\StreamInterface
     */
    public function bases(string $poi_id, string $begin_date, string $end_date)
    {
        $result = $this->app->http
            ->request('GET','https://open.douyin.com/data/external/poi/base', [
                \GuzzleHttp\RequestOptions::HEADERS => [
                    'Content-Type' => 'application/json',
                    'access-token' => $this->app->douyin_token->getToken()
                ],
                \GuzzleHttp\RequestOptions::QUERY => [
                    'poi_id' => $poi_id,
                    'begin_date' => $begin_date,
                    'end_date' => $end_date
                ]
            ])->getBody();

        return json_decode((string)$result, true) ?: $result;
    }

    /**
     * POI用户数据
     * @param string $poi_id
     * @param int $date_type
     * @return mixed|\Psr\Http\Message\StreamInterface
     */
    public function user(string $poi_id, int $date_type)
    {
        $result = $this->app->http
            ->request('GET','https://open.douyin.com/data/external/poi/user', [
                \GuzzleHttp\RequestOptions::HEADERS => [
                    'Content-Type' => 'application/json',
                    'access-token' => $this->app->douyin_token->getToken()
                ],
                \GuzzleHttp\RequestOptions::QUERY => [
                    'poi_id' => $poi_id,
                    'date_type' => $date_type
                ]
            ])->getBody();

        return json_decode((string)$result, true) ?: $result;
    }

    /**
     * POI服务基础数据
     * @param string $poi_id
     * @param string $begin_date
     * @param string $end_date
     * @param int|null $service_type
     * @return mixed|\Psr\Http\Message\StreamInterface
     */
    public function serviceBase(string $poi_id, string $begin_date, string $end_date, ?int $service_type = null)
    {
        $result = $this->app->http
            ->request('GET','https://open.douyin.com/data/external/poi/service_base', [
                \GuzzleHttp\RequestOptions::HEADERS => [
                    'Content-Type' => 'application/json',
                    'access-token' => $this->app->douyin_token->getToken()
                ],
                \GuzzleHttp\RequestOptions::QUERY => [
                    'poi_id' => $poi_id,
                    'begin_date' => $begin_date,
                    'end_date' => $end_date,
                    'service_type' => $service_type
                ]
            ])->getBody();

        return json_decode((string)$result, true) ?: $result;
    }

    /**
     * POI服务成交用户数据
     * @param string $poi_id
     * @param string $date_type
     * @param int|null $service_type
     * @return mixed|\Psr\Http\Message\StreamInterface
     */
    public function serviceUser(string $poi_id, string $date_type, ?int $service_type = null)
    {
        $result = $this->app->http
            ->request('GET','https://open.douyin.com/data/external/poi/service_user', [
                \GuzzleHttp\RequestOptions::HEADERS => [
                    'Content-Type' => 'application/json',
                    'access-token' => $this->app->douyin_token->getToken()
                ],
                \GuzzleHttp\RequestOptions::QUERY => [
                    'poi_id' => $poi_id,
                    'date_type' => $date_type,
                    'service_type' => $service_type
                ]
            ])->getBody();

        return json_decode((string)$result, true) ?: $result;
    }

    /**
     * POI热度榜
     * @param int $billboard_type
     * @return mixed|\Psr\Http\Message\StreamInterface
     */
    public function billboard(int $billboard_type)
    {
        $result = $this->app->http
            ->request('GET','https://open.douyin.com/data/external/poi/billboard', [
                \GuzzleHttp\RequestOptions::HEADERS => [
                    'Content-Type' => 'application/json',
                    'access-token' => $this->app->douyin_token->getToken()
                ],
                \GuzzleHttp\RequestOptions::QUERY => [
                    'billboard_type' => $billboard_type
                ]
            ])->getBody();

        return json_decode((string)$result, true) ?: $result;
    }

    /**
     * POI认领列表
     * @param string $open_id
     * @param int $count
     * @param string|null $cursor
     * @return mixed|\Psr\Http\Message\StreamInterface
     */
    public function claimList(string $open_id, int $count = 20, ?string $cursor = null)
    {
        $result = $this->app->http
            ->request('GET','https://open.douyin.com/data/external/poi/claim/list', [
                \GuzzleHttp\RequestOptions::HEADERS => [
                    'Content-Type' => 'application/json',
                    'access-token' => $this->app->client_token->getToken()
                ],
                \GuzzleHttp\RequestOptions::QUERY => [
                    'open_id' => $open_id,
                    'count' => $count,
                    'cursor' => $cursor,
                ]
            ])->getBody();

        return json_decode((string)$result, true) ?: $result;
    }

    /**
     * 通过高德POI ID获取抖音POI ID
     * @param string $amap_id
     * @return mixed|\Psr\Http\Message\StreamInterface
     */
    public function amap(string $amap_id)
    {
        $result = $this->app->http
            ->request('GET','https://open.douyin.com/poi/base/query/amap', [
                \GuzzleHttp\RequestOptions::HEADERS => [
                    'Content-Type' => 'application/json',
                    'access-token' => $this->app->douyin_token->getToken()
                ],
                \GuzzleHttp\RequestOptions::QUERY => [
                    'amap_id' => $amap_id
                ]
            ])->getBody();

        return json_decode((string)$result, true) ?: $result;
    }

    /**
     * 获取抖音POI ID
     * @param string $amap_id
     * @return mixed|\Psr\Http\Message\StreamInterface
     */
    public function queryPoiId(string $amap_id)
    {
        $result = $this->app->http
            ->request('GET','https://open.douyin.com/poi/query', [
                \GuzzleHttp\RequestOptions::HEADERS => [
                    'Content-Type' => 'application/json',
                    'access-token' => $this->app->client_token->getToken()
                ],
                \GuzzleHttp\RequestOptions::QUERY => [
                    'amap_id' => $amap_id
                ]
            ])->getBody();

        return json_decode((string)$result, true) ?: $result;
    }

}