<?php

use StephaneCoinon\Turbine\Exceptions\AuthenticationException;
use StephaneCoinon\Turbine\Turbine;

require 'vendor/autoload.php';

(\Dotenv\Dotenv::createImmutable(__DIR__ . '/..'))->load();

$turbine = new Turbine;

try {
    $turbine->login(getenv('TURBINE_EMAIL'), getenv('TURBINE_PASSWORD'));
    // $turbine->login('your_email@domain.com', 'your_turbine_password');
} catch (AuthenticationException $e) {
    echo 'Login failed: ' . $e->getMessage();
    die();
}

// Login succeeded...

$employees = $turbine->employees(); // returns a Collection of Employee instances
var_dump($employees);
