# Client for [turbinehq.com](https://turbinehq.com) API

[turbinehq.com](https://turbinehq.com) is an online web app to manage purchase orders, expenses and time-off requests.

This package is a client for their API.

_Note: I am not affiliated with nor endorsed by [turbinehq.com](https://turbinehq.com)_

## Installation

`composer require stephanecoinon/turbine`

## Usage

```php
<?php

use StephaneCoinon\Turbine\Exceptions\AuthenticationException;
use StephaneCoinon\Turbine\Turbine;

require 'vendor/autoload.php';

$turbine = new Turbine;

try {
    $turbine->login('your_email@domain.com', 'your_turbine_password');
} catch (AuthenticationException $e) {
    echo 'Login failed: ' . $e->getMessage();
    die();
}

// Login succeeded...

$employees = $turbine->employees(); // returns a Collection of Employee instances

```

## Tests

`./vendor/bin/phpunit`

## License

This package is open-sourced software licensed under the [MIT license](./LICENSE.md).
