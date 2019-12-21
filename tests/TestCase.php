<?php

namespace StephaneCoinon\Turbine\Tests;

use Dotenv\Dotenv;
use Mockery;

class TestCase extends \PHPUnit\Framework\TestCase
{
    public function setUp(): void
    {
        parent::setUp();

        $dotenv = Dotenv::createImmutable(__DIR__.'/..');
        $dotenv->load();
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
