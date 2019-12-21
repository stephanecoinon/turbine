<?php

namespace StephaneCoinon\Turbine\Tests;

use Mockery;

class TestCase extends \PHPUnit\Framework\TestCase
{
    use Traits\LoadsDotEnv;

    public function setUp(): void
    {
        $this->loadDotEnv();

        parent::setUp();
    }

    public function tearDown(): void
    {
        parent::tearDown();

        Mockery::close();
    }

    public function pass()
    {
        $this->assertTrue(true);
    }
}
