<?php

namespace Xyu\TtApp;

use Doctrine\Common\Cache\Cache;
use Hanson\Foundation\Foundation;
use Xyu\TtApp\Douyin\Account;
use Xyu\TtApp\Douyin\PreparceOrder;

/**
 * Class TtApp
 * @package Xyu\TtApp
 *
 * @property-read AccessToken $access_token
 * @property-read Auth $auth
 * @property-read QrCode $qr_code
 * @property-read Storage $storage
 * @property-read TempMsg $temp_msg
 * @property-read ContentSecurity $content_security
 * @property-read Decrypt $decrypt
 * @property-read Payment $payment
 *
 * @property-read Account $account
 * @property-read \Xyu\TtApp\Douyin\AccessToken $douyin_token
 * @property-read PreparceOrder $preparce_order
 * @property-read Cache $cache
 */
class TtApp extends Foundation
{
    protected $providers = [
        ServiceProvider::class,
    ];

    public function __construct($config)
    {
        if (!isset($config['debug'])) {
            $config['debug'] = $this->config['debug'] ?? false;
        }
        parent::__construct($config);
    }

    public function getTimeout()
    {
        return $this->getConfig('timout') ?: 5;
    }

    public function getAppId()
    {
        return $this->getConfig('access_key');
    }

    public function getAppSecret()
    {
        return $this->getConfig('secret_key');
    }

    public function getPaymentAppId()
    {
        return $this->getConfig('payment_app_id');
    }

    public function getPaymentSecret()
    {
        return $this->getConfig('payment_secret');
    }

    public function getPaymentMerchantId()
    {
        return $this->getConfig('payment_merchant_id');
    }

    public function getPaymentSalt()
    {
        return $this->getConfig('payment_salt');
    }

    public function getPaymentToken()
    {
        return $this->getConfig('payment_token');
    }

    public function getClientKey()
    {
        return $this->getConfig('client_key');
    }

    public function getClientSecret()
    {
        return $this->getConfig('client_secret');
    }

    public function rebind(string $id, $value)
    {
        $this->offsetUnset($id);
        $this->offsetSet($id, $value);

        return $this;
    }
}