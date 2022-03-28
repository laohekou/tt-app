<?php

namespace Xyu\TtApp;

use Hanson\Foundation\Foundation;
use Qbhy\TtMicroApp\ServiceProvider;

class TtApp extends Foundation
{
    protected $providers = [
        ServiceProvider::class,
    ];

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

    public function rebind(string $id, $value)
    {
        $this->offsetUnset($id);
        $this->offsetSet($id, $value);

        return $this;
    }
}