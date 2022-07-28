<?php

namespace Xyu\TtApp\Contract;

use Xyu\TtApp\Exception\DyTokenException;
use Xyu\TtApp\Exception\KaBusinessException;
use Xyu\TtApp\TtApp;

abstract class AbstractGateway
{

    protected $app;

    public $check;

    public $nonceStr;

    public $timestamp;

    public function setCheckToken(bool $check = false)
    {
        $this->check = $check;
        return $this;
    }

    public function getCheckToken()
    {
        return $this->check;
    }

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
                if(isset($result['data']['error_code']) && $result['data']['error_code'] == 0) {
                    $res = $this->app->douyin_token->setRefreshToken($result['data']['refresh_token'])->getToken();
                    if(isset($res['error_code']) && $res['error_code'] == 0) {
                        return true;
                    }else{
                        throw new DyTokenException('刷新refresh_token后获取token失败，重新走用户授权流程', $res['error_code'] ?? 8888);
                    }
                }else{
                    throw new DyTokenException('刷新refresh_token失败，重新走用户授权流程', $result['data']['error_code'] ?? 7777);
                }
            } elseif (isset($resp['error_code']) && $resp['error_code'] == 0) {
                return true;
            }else{
                throw new DyTokenException('刷新access_token异常，重新走用户授权流程', $resp['error_code'] ?? 9999);
            }
        } else {
            // 非token状态码不处理
            return;
        }
    }

    /**
     * 抖音手机号解密
     * @param string $encrypted_mobile
     * @return false|string
     */
    public function mobileDecrypt(string $encrypted_mobile) {
        $iv = substr($this->app->getClientSecret(), 0, 16);
        return openssl_decrypt($encrypted_mobile, 'aes-256-cbc', $this->app->getClientSecret(), 0, $iv);
    }

    /**
     * 抖音交易系统2.0签名生成
     * @param string $url
     * @param string $body
     * @param string $method
     * @return string
     * @throws KaBusinessException
     */
    public function kaSign(string $url, string $body, string $method = 'POST')
    {
        $this->timestamp = time();
        $this->nonceStr = strtoupper(md5((uniqid(mt_rand(0,999999), true)) . microtime()));
        $sign = $this->app->decrypt->makeSign($method, $url, $body, $this->timestamp, $this->nonceStr);

        $this->checkSign($body, $this->timestamp, $this->nonceStr, $sign);

        return $sign;
    }

    /**
     * 抖音交易系统2.0验证签名
     * @param string $body
     * @param int $timestamp
     * @param string $nonceStr
     * @param string $sign
     * @throws KaBusinessException
     */
    public function checkSign(string $body, int $timestamp, string $nonceStr, string $sign)
    {
        if(! $this->app->decrypt->verify($body, $timestamp, $nonceStr, $sign) ) {
            throw new KaBusinessException('check sign err !');
        }
    }


    public function returnResp()
    {

    }

}