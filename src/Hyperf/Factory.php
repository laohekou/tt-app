<?php

namespace Xyu\TtApp\Hyperf;

use Hyperf\Contract\ConfigInterface;
use Xyu\TtApp\Factory as BaseFactory;

class Factory extends BaseFactory
{
    protected $config;

    protected $drivers;

    public function __construct(ConfigInterface $config)
    {
        parent::__construct($config->get('tt-app', []));
    }

    public function make(?string $name = null, ?array $config = null)
    {
        $app = parent::make($name);

        $app->rebind('guzzle_handler', 'Hyperf\Guzzle\CoroutineHandler');

        return $app;
    }
}