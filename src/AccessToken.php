<?php

namespace Xyu\TtApp;

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

    protected $cacheKey = 'toutiao-token';

    public function getTokenFromServer()
    {
        $data = json_decode((string)$this->app->http->json('https://developer.toutiao.com/api/apps/v2/token', [
            'appid' => $this->app->getAppId(),
            'secret' => $this->app->getAppSecret(),
            'grant_type' => 'client_credential',
        ])->getBody(), true);
        return [
            'err_no' => $data['err_no'] ?? null,
            'err_tips' => $data['err_tips'] ?? null,
            'access_token' => $data['data']['access_token'] ?? null,
            'expires_in' => isset($data['data']['expires_in']) ? (int)$data['data']['expires_in'] - 1 : 0,
        ];
    }

    public function checkTokenResponse($result)
    {
        if (isset($result['err_no']) && $result['err_no'] !== 0) {
            throw new TtAppException("获取字节小程序 access token 失败：{$result['err_tips']}");
        }
    }
}