<?php

namespace StephaneCoinon\Turbine\Tests\Traits;

use Dotenv\Dotenv;

trait LoadsDotEnv
{
    public function loadDotEnv()
    {
        $dotenv = Dotenv::create(__DIR__ . '/../..');
        $dotenv->load();
    }
}
