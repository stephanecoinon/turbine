<?php

namespace StephaneCoinon\Turbine\Laravel;

use Illuminate\Support\ServiceProvider;
use StephaneCoinon\Turbine\Turbine;

class TurbineServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(Turbine::class, function ($app) {
            $config = $app['config']->get('services.turbine');

            return (new Turbine($config['url']))->login(
                $config['email'],
                $config['password'],
            );
        });
    }
}
