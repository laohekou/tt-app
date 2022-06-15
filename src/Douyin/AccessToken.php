<?php

namespace Xyu\TtApp\Douyin;

use Hanson\Foundation\AbstractAccessToken;
use Xyu\TtApp\Exception\TtAppException;

/**
 * 凭证
 * class AccessToken
 */
class AccessToken extends AbstractAccessToken
{
    protected $tokenJsonKey = 'access_token';

    protected $expiresJsonKey = 'expires_in';

    protected $cacheKey = 'dy-token';

    // 抖音授权码
    protected $code;

    // 抖音refresh_token(通过access_token获取到的refresh_token参数)
    protected $refresh_token;

    // 是否刷新access_token
    protected $isRefreshToken = false;

    /**
     * @param string $code
     */
    public function setCode($code)
    {
        $this->code = $code;
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
        $this->refreshToken = $refreshToken;
    }

    /**
     * @return string|null
     */
    public function getRefreshToken()
    {
        return $this->refreshToken;
    }

    /**
     * @param bool $isRefreshToken
     */
    public function setIsRefreshToken($isRefreshToken)
    {
        $this->isRefreshToken = $isRefreshToken;
    }

    /**
     * @return bool
     */
    public function getIsRefreshToken()
    {
        return $this->isRefreshToken;
    }

    public function getTokenFromServer()
    {
        if(! $this->getIsRefreshToken()) {
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
            'access_token' => $data['data']['access_token'] ?? null,
            'expires_in' => isset($data['data']['expires_in']) ? (int)$data['data']['expires_in'] - 5 : 0,
        ];
    }

    public function checkTokenResponse($result)
    {
        if (isset($result['error_code']) && $result['error_code'] !== '0') {
            throw new TtAppException("获取抖音access_token 失败：{$result['err_tips']}", $result['error_code']);
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

    /**
     * 生成client_token
     * @return mixed|\Psr\Http\Message\StreamInterface
     */
    public function clientToken()
    {
        $result = $this->app->http
            ->request('POST','https://open.douyin.com/oauth/client_token', [
                \GuzzleHttp\RequestOptions::HEADERS => ['Content-Type' => 'multipart/form-data'],
                \GuzzleHttp\RequestOptions::FORM_PARAMS => [
                    'client_key' => $this->app->getClientKey(),
                    'client_secret' => $this->app->getClientSecret(),
                    'grant_type' => 'client_credential',
                ]
            ])->getBody();

        return json_decode((string)$result, true) ?: $result;
    }

}