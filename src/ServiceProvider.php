<?php

namespace Xyu\TtApp;

use Hanson\Foundation\Http;
use Pimple\Container;
use Pimple\ServiceProviderInterface;

class ServiceProvider implements ServiceProviderInterface
{

    public function register(Container $pimple)
    {
        $pimple['http'] = function (TtApp $microApp) {
            return new Http($microApp);
        };

        $pimple['access_token'] = function (TtApp $ttApp) {
            return (new AccessToken($ttApp))->setCache($ttApp->cache);
        };

    }
}