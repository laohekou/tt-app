<?php

namespace Xyu\TtApp;

use Hanson\Foundation\Http;
use Pimple\Container;
use Pimple\ServiceProviderInterface;

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
    }
}