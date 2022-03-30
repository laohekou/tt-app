<?php

if (!function_exists('get_client_ip')) {
    function get_client_ip()
    {
        if (!empty($_SERVER['REMOTE_ADDR'])) {
            $ip = $_SERVER['REMOTE_ADDR'];
        } else {
            // for php-cli(phpunit etc.)
            $ip = defined('PHPUNIT_RUNNING') ? '127.0.0.1' : gethostbyname(gethostname());
        }

        return filter_var($ip, FILTER_VALIDATE_IP) ?: '127.0.0.1';
    }
}

if (!function_exists('tt_app')) {
    function tt_app(array $config)
    {
        return new \Xyu\TtApp\TtApp($config);
    }
}

if (!function_exists('ttapp')) {
    function ttapp(string $name = 'default')
    {
        return \Hyperf\Utils\ApplicationContext::getContainer()->get(\Xyu\TtApp\Hyperf\Factory::class)->make($name);
    }
}