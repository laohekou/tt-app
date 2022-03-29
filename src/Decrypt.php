<?php

namespace Xyu\TtApp;

use Xyu\TtApp\Exception\DecryptException;
use Xyu\TtApp\Support\AES;

class Decrypt
{
    protected $app;

    public function __construct(TtApp $ttApp)
    {
        $this->app = $ttApp;
    }

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
}