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

    public function getTokenFromServer()
    {
        return json_decode((string)$this->app->http->post('https://developer.toutiao.com/api/apps/v2/token', [
            'appid' => $this->app->getAppId(),
            'secret' => $this->app->getAppSecret(),
            'grant_type' => 'client_credential',
        ])->getBody(), true);
    }

    public function checkTokenResponse($result)
    {
        if (isset($result['err_no']) && $result['err_no'] !== 0) {
            throw new TtAppException("获取 access token 失败：{$result['err_tips']}");
        }
    }
}