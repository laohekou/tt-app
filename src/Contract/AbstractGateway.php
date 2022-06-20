<?php

namespace Xyu\TtApp\Contract;

use Xyu\TtApp\Exception\DyTokenException;
use Xyu\TtApp\TtApp;

abstract class AbstractGateway
{

    protected $app;

    public function __construct(TtApp $ttApp)
    {
        $this->app = $ttApp;
    }


    public function dyAccessToken()
    {
        $accessToken = $this->app->douyin_token->getToken()['access_token'] ?? '';
        if(! $accessToken) {
            throw new DyTokenException('获取raccess_token失败，重新走用户授权流程');
        }
        return $accessToken;
    }


    /**
     * access_token状态检测及更新
     * @param int $errorCode
     * @return bool|void
     * @throws DyTokenException
     */
    public function checkToken(int $errorCode)
    {
        if($errorCode == 10010)
        {
            throw new DyTokenException('重新走用户授权流程', $errorCode);
        } elseif ($errorCode == 10008 || $errorCode == 2190008)
        {
            $resp = $this->app->douyin_token->setRefreshToken($this->app->douyin_token->getToken()['refresh_token'])->getToken();
            if(isset($resp['error_code']) && $resp['error_code'] == 10010)
            {
                $result = $this->app->douyin_token->renewRefreshToken($this->app->douyin_token->getToken()['refresh_token']);
                if(isset($result['error_code']) && $result['error_code'] == 0) {
                    $res = $this->app->douyin_token->setRefreshToken($result['data']['refresh_token'])->getToken();
                    if(isset($res['error_code']) && $res['error_code'] == 0) {
                        return true;
                    }else{
                        throw new DyTokenException('刷新refresh_token后获取token失败，重新走用户授权流程', $res['error_code']);
                    }
                }else{
                    throw new DyTokenException('刷新refresh_token失败，重新走用户授权流程', $result['error_code']);
                }
            } elseif (isset($resp['error_code']) && $resp['error_code'] == 0) {
                return true;
            }else{
                throw new DyTokenException('刷新access_token异常，重新走用户授权流程', $resp['error_code']);
            }
        } else {
            // 非token状态码不处理
            return;
        }
    }

}