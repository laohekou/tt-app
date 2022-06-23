<?php

namespace Xyu\TtApp\Douyin;

use Hanson\Foundation\AbstractAccessToken;
use Xyu\TtApp\Exception\TtAppException;

/**
 * 凭证
 * class ClientToken
 */
class ClientToken extends AbstractAccessToken
{
    protected $tokenJsonKey = 'access_token';

    protected $expiresJsonKey = 'expires_in';

    protected $cacheKey = 'dy-cli-token';

    /**
     * @return array
     */
    public function getTokenFromServer()
    {
        $result = $this->app->http
            ->request('POST','https://open.douyin.com/oauth/client_token', [
                \GuzzleHttp\RequestOptions::HEADERS => ['Content-Type' => 'multipart/form-data'],
                \GuzzleHttp\RequestOptions::QUERY => [
                    'client_key' => $this->app->getClientKey(),
                    'client_secret' => $this->app->getClientSecret(),
                    'grant_type' => 'client_credential',
                ]
            ])->getBody();

        $data = json_decode((string)$result, true) ?: $result;
        return [
            'error_code' => $data['data']['error_code'] ?? null,
            'err_tips' => json_encode($data, JSON_UNESCAPED_UNICODE),
            'access_token' => $data['data']['access_token'] ?? null,
            'expires_in' => isset($data['data']['expires_in']) ? (int)$data['data']['expires_in'] - 5 : 0,
        ];
    }

    public function checkTokenResponse($result)
    {
        if (! isset($result['error_code']) || $result['error_code'] != 0) {
            throw new TtAppException("获取抖音client_token 失败：{$result['err_tips']}", $result['error_code']);
        }
    }

}