<?php

namespace Xyu\TtApp\Laravel;

use Illuminate\Support\ServiceProvider as LaravelServiceProvider;
use Laravel\Lumen\Application;
use Xyu\TtApp\Factory;
use Xyu\TtApp\TtApp;

/**
 * Class LaravelServiceProvider
 *
 * @author  xyu
 *
 */
class ServiceProvider extends LaravelServiceProvider
{
    /**
     * Setup the config.
     */
    protected function setupConfig()
    {
        $source = dirname(__DIR__).'/config/tt-app.php';
        if ($this->app->runningInConsole()) {
            $this->publishes([$source => base_path('config/tt-app.php')], 'tt-app');
        }

        if ($this->app instanceof Application) {
            $this->app->configure('tt-app');
        }

        $this->mergeConfigFrom($source, 'tt-app');
    }

    public function register()
    {
        $this->setupConfig();

        $this->app->singleton(TtApp::class, function ($app) {
            return app(Factory::class)->make();
        });

        $this->app->singleton(Factory::class, function ($app) {
            return new Factory(config('tt-app'));
        });

        $this->app->alias(Factory::class, 'tt.factory');
        $this->app->alias(TtApp::class, 'tt.app');
    }
}