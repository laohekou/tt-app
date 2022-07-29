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

    protected $cacheKey = 'zj-token';

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
            'expires_in' => isset($data['data']['expires_in']) ? (int)$data['data']['expires_in'] - 5 : 0,
        ];
    }

    public function checkTokenResponse($result)
    {
        if (! isset($result['err_no']) || $result['err_no'] !== 0) {
            throw new TtAppException("获取字节小程序access_token 失败：{$result['err_tips']}");
        }
    }


    public function get_lock_token($forceRefresh = false)
    {
        $cached = $this->getCache()->fetch($this->getCacheKey()) ?: $this->token;

        if ($forceRefresh || empty($cached)) {

            if(class_exists('Hyperf\Redis\Redis')) {
                if( _redis()->set($this->cacheKey, '1', ['nx', 'px' => 650]) ) {
                    $result = $this->getTokenFromServer();

                    $this->checkTokenResponse($result);

                    $this->setToken(
                        $token = $result[$this->tokenJsonKey],
                        $this->expiresJsonKey ? $result[$this->expiresJsonKey] : null
                    );

                    return $token;
                }else{
                    usleep(650 * 1000); // 毫秒
                    return $this->get_lock_token($forceRefresh);
                }
            }else{
                return $this->getToken($forceRefresh);
            }
        }

        return $cached;
    }

}