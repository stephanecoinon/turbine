<?php

namespace StephaneCoinon\Turbine\Tests;

use StephaneCoinon\Turbine\Laravel\TurbineServiceProvider;

class LaravelTestCase extends \Orchestra\Testbench\TestCase
{
    use Traits\LoadsDotEnv;

    public function setUp(): void
    {
        $this->loadDotEnv();

        parent::setUp();
    }

    protected function getPackageProviders($app)
    {
        return [TurbineServiceProvider::class];
    }

    protected function getEnvironmentSetUp($app)
    {
        $app['config']->set('services.turbine', [
            'email' => env('TURBINE_EMAIL'),
            'password' => env('TURBINE_PASSWORD'),
            'url' => env('TURBINE_URL'),
        ]);
    }
}
