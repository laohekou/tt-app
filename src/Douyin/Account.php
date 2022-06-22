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
            ->request('GET','https://open.douyin.com/oauth/authorize/v2', [
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

}