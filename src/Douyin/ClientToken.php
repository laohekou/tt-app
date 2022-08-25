<?php

namespace Xyu\TtApp\Douyin;

use Hanson\Foundation\AbstractAccessToken;
use Xyu\TtApp\Exception\DyTokenException;

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
                \GuzzleHttp\RequestOptions::FORM_PARAMS => [
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
            throw new DyTokenException("获取抖音client_token 失败：{$result['err_tips']}", $result['error_code']);
        }
    }


    public function get_lock_token($forceRefresh = false)
    {
        $cached = $this->getCache()->fetch($this->getCacheKey()) ?: $this->token;

        if ($forceRefresh || empty($cached)) {

            if(class_exists('Hyperf\Redis\Redis')) {
                if( _redis()->set($this->cacheKey, '1', ['nx', 'px' => 1000]) ) {
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