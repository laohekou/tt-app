<?php

namespace Xyu\TtApp\Douyin;

use Hanson\Foundation\AbstractAccessToken;
use Hyperf\Redis\Redis;
use Xyu\TtApp\Exception\DyTokenException;

/**
 * 凭证
 * class AccessToken
 */
class AccessToken extends AbstractAccessToken
{
    protected $tokenJsonKey = 'access_token';

    protected $expiresJsonKey = 'expires_in';

    protected $cacheKey = 'dy-token';

    /**
     * @var Redis
     */
    protected $redis;

    // 抖音授权码
    protected $code;

    // 抖音refresh_token(通过access_token获取到的refresh_token参数)
    protected $refresh_token;

    /**
     * @param string $code
     */
    public function setCode($code)
    {
        $this->code = $code;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * @param string $code
     */
    public function setRefreshToken($refreshToken)
    {
        $this->refresh_token = $refreshToken;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getRefreshToken()
    {
        return $this->refresh_token;
    }

    /**
     *  1. 若 access_token 已过期，调用接口会报错(error_code=10008 或 2190008)，refresh_token 后会获取一个新的 access_token 以及新的超时时间。
     *  2. 若 access_token 未过期，refresh_token 不会改变原来的 access_token，但超时时间会更新，相当于续期。
     *  3. 若 refresh_token 过期，获取 access_token 会报错(error_code=10010)，此时需要重新走用户授权流程。
     * @return array
     */
    public function getTokenFromServer()
    {
        if(! $this->getRefreshToken()) {
            $data = $this->app->http
                    ->request('POST','https://open.douyin.com/oauth/access_token', [
                        \GuzzleHttp\RequestOptions::HEADERS => ['Content-Type' => 'application/x-www-form-urlencoded'],
                        \GuzzleHttp\RequestOptions::FORM_PARAMS => [
                            'code' => $this->getCode(), // 抖音获取授权码
                            'client_secret' => $this->app->getClientSecret(),
                            'client_key' => $this->app->getClientKey(),
                            'grant_type' => 'authorization_code',
                        ]
                    ])->getBody();
            $data = json_decode((string)$data, true);
        }else{
            $data = $this->refreshToken($this->getRefreshToken());
        }
        return [
            'error_code' => $data['error_code'] ?? null,
            'err_tips' => json_encode($data, JSON_UNESCAPED_UNICODE),
            'access_token' => $data['data'] ?? null, // 包含access_token、refresh_token、openid等
            'expires_in' => isset($data['data']['expires_in']) ? (int)$data['data']['expires_in'] - 5 : 0,
        ];
    }

    public function checkTokenResponse($result)
    {
        if (! isset($result['error_code']) || $result['error_code'] != 0) {
            throw new DyTokenException("获取抖音access_token 失败：{$result['err_tips']}", $result['error_code']);
        }
    }


    /**
     * 刷新 access_token
     * @param string $refreshToken
     * @return mixed|\Psr\Http\Message\StreamInterface
     */
    public function refreshToken(string $refreshToken)
    {
        $result = $this->app->http
                    ->request('POST','https://open.douyin.com/oauth/refresh_token', [
                        \GuzzleHttp\RequestOptions::HEADERS => ['Content-Type' => 'multipart/form-data'],
                        \GuzzleHttp\RequestOptions::FORM_PARAMS => [
                            'client_key' => $this->app->getClientKey(),
                            'grant_type' => 'refresh_token',
                            'refresh_token' => $refreshToken, // 填写通过access_token获取到的refresh_token参数
                        ]
                    ])->getBody();

        return json_decode((string)$result, true) ?: $result;
    }

    /**
     * 刷新refresh_token
     * @param string $refreshToken
     * @return mixed|\Psr\Http\Message\StreamInterface
     */
    public function renewRefreshToken(string $refreshToken)
    {
        $result = $this->app->http
                    ->request('POST','https://open.douyin.com/oauth/renew_refresh_token', [
                        \GuzzleHttp\RequestOptions::HEADERS => ['Content-Type' => 'multipart/form-data'],
                        \GuzzleHttp\RequestOptions::FORM_PARAMS => [
                            'client_key' => $this->app->getClientKey(),
                            'refresh_token' => $refreshToken, // 填写通过access_token获取到的refresh_token参数
                        ]
                    ])->getBody();

        return json_decode((string)$result, true) ?: $result;
    }


    public function get_lock_token($forceRefresh = false)
    {
        $cached = $this->getCache()->fetch($this->getCacheKey()) ?: $this->token;

        if ($forceRefresh || empty($cached)) {

            if( $this->redis->set($this->cacheKey, '1', ['nx', 'px' => 200]) ) {
                $result = $this->getTokenFromServer();

                $this->checkTokenResponse($result);

                $this->setToken(
                    $token = $result[$this->tokenJsonKey],
                    $this->expiresJsonKey ? $result[$this->expiresJsonKey] : null
                );

                return $token;
            }else{
                usleep(200 * 1000); // 毫秒
                return $this->getToken($forceRefresh);
            }
        }

        return $cached;
    }

}