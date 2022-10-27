<?php

namespace Xyu\TtApp;

use Hanson\Foundation\Http;
use Pimple\Container;
use Pimple\ServiceProviderInterface;
use Xyu\TtApp\Douyin\Account;
use Xyu\TtApp\Douyin\KA\KaOrder;
use Xyu\TtApp\Douyin\LifeService\Cps;
use Xyu\TtApp\Douyin\LifeService\Poi;
use Xyu\TtApp\Douyin\LifeService\PreparceCode;
use Xyu\TtApp\Douyin\LifeService\Shops;
use Xyu\TtApp\Douyin\KA\Goods;

class ServiceProvider implements ServiceProviderInterface
{

    public function register(Container $pimple)
    {
        $pimple['http'] = function (TtApp $ttApp) {
            return new Http($ttApp);
        };

        $pimple['access_token'] = function (TtApp $ttApp) {
            return (new AccessToken($ttApp))->setCache($ttApp->cache);
        };

        $pimple['auth'] = function (TtApp $ttApp) {
            return new Auth($ttApp);
        };

        $pimple['storage'] = function (TtApp $ttApp) {
            return new Storage($ttApp);
        };

        $pimple['qr_code'] = function (TtApp $ttApp) {
            return new QrCode($ttApp);
        };

        $pimple['temp_msg'] = function (TtApp $ttApp) {
            return new TempMsg($ttApp);
        };

        $pimple['content_security'] = function (TtApp $ttApp) {
            return new ContentSecurity($ttApp);
        };

        $pimple['decrypt'] = function (TtApp $ttApp) {
            return new Decrypt($ttApp);
        };

        $pimple['payment'] = function (TtApp $ttApp) {
            return new Payment($ttApp);
        };

        // 抖音开放平台接口
        $pimple['account'] = function (TtApp $ttApp) {
            return new Account($ttApp);
        };

        $pimple['douyin_token'] = function (TtApp $ttApp) {
            return (new \Xyu\TtApp\Douyin\AccessToken($ttApp))->setCache($ttApp->cache);
        };

        $pimple['client_token'] = function (TtApp $ttApp) {
            return (new \Xyu\TtApp\Douyin\ClientToken($ttApp))->setCache($ttApp->cache);
        };

        $pimple['preparce_code'] = function (TtApp $ttApp) {
            return new PreparceCode($ttApp);
        };

        $pimple['shops'] = function (TtApp $ttApp) {
            return new Shops($ttApp);
        };

        $pimple['poi'] = function (TtApp $ttApp) {
            return new Poi($ttApp);
        };

        $pimple['cps'] = function (TtApp $ttApp) {
            return new Cps($ttApp);
        };

        $pimple['goods'] = function (TtApp $ttApp) {
            return new Goods($ttApp);
        };

        $pimple['ka_order'] = function (TtApp $ttApp) {
            return new KaOrder($ttApp, $ttApp->getNonceStr());
        };
    }
}