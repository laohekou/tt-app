<?php

namespace Xyu\TtApp;

use Xyu\TtApp\Contract\AbstractGateway;
use Xyu\TtApp\Exception\DecryptException;
use Xyu\TtApp\Support\AES;

class Decrypt extends AbstractGateway
{
    /**
     * 解密敏感数据
     * @param string $encryptedData
     * @param string $sessionKey
     * @param string $iv
     * @return array
     * @throws DecryptException
     */
    public function decrypt(string $encryptedData, string $sessionKey, string $iv)
    {
        $decrypted = AES::decrypt(
            base64_decode($encryptedData, false), base64_decode($sessionKey, false), base64_decode($iv, false)
        );

        $decrypted = @json_decode($decrypted, true);

        if (!$decrypted) {
            throw new DecryptException('The given payload is invalid.');
        }

        return $decrypted;
    }

    // 抖音交易系统2.0签名生成
    public function makeSign(string $method, string $url, string $body, int $timestamp, string $nonce_str)
    {
        $text = $method . "\n" . $url . "\n" . $timestamp . "\n" . $nonce_str . "\n" . $body . "\n";
        $priKey = file_get_contents("/private_key.pem");
        $privateKey = openssl_get_privatekey($priKey, '');
        openssl_sign($text, $sign, $privateKey, OPENSSL_ALGO_SHA256);
        $sign = base64_encode($sign);
        return $sign;
    }

    // 抖音交易系统2.0验证签名
    public function verify(string $http_body, int $timestamp, string $nonce_str, string $sign)
    {
        $data = $timestamp . "\n" . $nonce_str . "\n" . $http_body . "\n";
        $publicKey = file_get_contents("/platform_public_key.pem");
        if (! $publicKey) {
            return null;
        }
        $res = openssl_get_publickey($publicKey);
        $result = (bool)openssl_verify($data, base64_decode($sign), $res, OPENSSL_ALGO_SHA256);
        openssl_free_key($res);
        return $result;
    }

}