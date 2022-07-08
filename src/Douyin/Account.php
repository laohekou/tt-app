<?php

namespace Xyu\TtApp\Douyin;

use Xyu\TtApp\Contract\AbstractGateway;

class Account extends AbstractGateway
{
    /**
     * 抖音获取授权码
     * @param string $redirectUri
     * @param array $scope
     * @param string $state
     * @return mixed|\Psr\Http\Message\StreamInterface
     */
    public function scope(string $redirectUri, array $scope = [], string $state = '', array $optionalScope = [])
    {
        $result = $this->app->http
                    ->request('GET','https://open.douyin.com/platform/oauth/connect', [
                        \GuzzleHttp\RequestOptions::HEADERS => ['Content-Type' => 'application/json'],
                        \GuzzleHttp\RequestOptions::QUERY => [
                            'client_key' => $this->app->getClientKey(),
                            'response_type' => 'code',
                            'scope' => $scope ? implode(',', $scope) : 'user_info',
                            'optionalScope' => $optionalScope ? implode(',', $optionalScope) : '',
                            'redirect_uri' => $redirectUri,
                            'state' => $state,
                        ]
                    ])->getBody();

        return json_decode((string)$result, true) ?: $result;
    }

    /**
     * 抖音静默获取授权码
     * @param string $redirectUri
     * @param string $state
     * @return mixed|\Psr\Http\Message\StreamInterface
     */
    public function authorizeV2(string $redirectUri, string $state = '')
    {
        $result = $this->app->http
            ->request('GET','https://aweme.snssdk.com/oauth/authorize/v2', [
                \GuzzleHttp\RequestOptions::HEADERS => ['Content-Type' => 'application/json'],
                \GuzzleHttp\RequestOptions::QUERY => [
                    'client_key' => $this->app->getClientKey(),
                    'response_type' => 'code',
                    'scope' => 'login_id',
                    'redirect_uri' => $redirectUri,
                    'state' => $state,
                ]
            ])->getBody();

        return json_decode((string)$result, true) ?: $result;
    }


    /**
     * 会员数据更新
     * @param array $params
     * @return mixed|\Psr\Http\Message\StreamInterface
     */
    public function memberUp(array $params)
    {
        $result = $this->app->http
            ->request('POST','https://open.douyin.com/goodlife/v1/member/user/update', [
                \GuzzleHttp\RequestOptions::HEADERS => [
                    'Content-Type' => 'application/json',
                    'access-token' => $this->app->client_token->getToken(),
                ],
                \GuzzleHttp\RequestOptions::JSON => $params
            ])->getBody();

        return json_decode((string)$result, true) ?: $result;
    }

    /**
     * 获取用户公开信息
     * @param string $open_id
     * @return mixed|\Psr\Http\Message\StreamInterface
     */
    public function userinfo(string $open_id)
    {
        $result = $this->app->http
            ->request('POST','https://open.douyin.com/oauth/userinfo', [
                \GuzzleHttp\RequestOptions::HEADERS => [
                    'Content-Type' => 'application/json',
                    'access-token' => $this->app->douyin_token->getToken(),
                ],
                \GuzzleHttp\RequestOptions::JSON => [
                    'access_token' => $this->app->douyin_token->getToken(),
                    'open_id' => $open_id,
                ]
            ])->getBody();

        return json_decode((string)$result, true) ?: $result;
    }

    /**
     * 获取粉丝列表
     * @param string $open_id
     * @param int $count
     * @param int|null $cursor
     * @return mixed|\Psr\Http\Message\StreamInterface
     */
    public function fansList(string $open_id, int $count = 20, int $cursor = null)
    {
        $result = $this->app->http
            ->request('GET','https://open.douyin.com/fans/list', [
                \GuzzleHttp\RequestOptions::HEADERS => [
                    'Content-Type' => 'application/json',
                    'access-token' => $this->app->douyin_token->getToken(),
                ],
                \GuzzleHttp\RequestOptions::JSON => [
                    'count' => $count,
                    'open_id' => $open_id,
                    'cursor' => $cursor,
                ]
            ])->getBody();

        return json_decode((string)$result, true) ?: $result;
    }


    /**
     * 获取关注列表
     * @param string $open_id
     * @param int $count
     * @param int|null $cursor
     * @return mixed|\Psr\Http\Message\StreamInterface
     */
    public function followingList(string $open_id, int $count = 20, int $cursor = null)
    {
        $result = $this->app->http
            ->request('GET','https://open.douyin.com/following/list', [
                \GuzzleHttp\RequestOptions::HEADERS => [
                    'Content-Type' => 'application/json',
                    'access-token' => $this->app->douyin_token->getToken(),
                ],
                \GuzzleHttp\RequestOptions::JSON => [
                    'count' => $count,
                    'open_id' => $open_id,
                    'cursor' => $cursor,
                ]
            ])->getBody();

        return json_decode((string)$result, true) ?: $result;
    }

    /**
     * 粉丝判断
     * @param string $follower_open_id
     * @param string $open_id
     * @return mixed|\Psr\Http\Message\StreamInterface
     */
    public function fansCheck(string $follower_open_id, string $open_id)
    {
        $result = $this->app->http
            ->request('GET','https://open.douyin.com/fans/check', [
                \GuzzleHttp\RequestOptions::HEADERS => [
                    'Content-Type' => 'application/json',
                    'access-token' => $this->app->douyin_token->getToken(),
                ],
                \GuzzleHttp\RequestOptions::JSON => [
                    'follower_open_id' => $follower_open_id,
                    'open_id' => $open_id
                ]
            ])->getBody();

        return json_decode((string)$result, true) ?: $result;
    }

}