# Client for [turbinehq.com](https://turbinehq.com) API

[turbinehq.com](https://turbinehq.com) is an online web app to manage purchase orders, expenses and time-off requests.

This package is a client for their API.

_Note: I am not affiliated with nor endorsed by [turbinehq.com](https://turbinehq.com)_

## Installation

`composer require stephanecoinon/turbine`

### Integration with Laravel

Although this package is vanilla PHP, it offers a Laravel service provider which
binds an authenticated `Turbine` instance in the container.

Laravel version >= 5.5 will discover the package and register the service provider
automatically.

Add these parameters to your `.env`:

```ini
TURBINE_EMAIL=your_email
TURBINE_PASSWORD=your_password
# Replace "yourcompany" below with your turbinehq subdomain:
TURBINE_URL=https://yourcompany.turbinehq.com/api/v1/
```

Add this `turbine` configuration key to your `config/services.php`:

```php
return [
    // ...

    'turbine' => [
        'email' => env('TURBINE_EMAIL'),
        'password' => env('TURBINE_PASSWORD'),
        'url' => env('TURBINE_URL'),
    ],

    // ...
];
```

## Usage in plain PHP

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

## Usage in Laravel

You can resolve an authenticated instance of `\StephaneCoinon\Turbine\Turbine` out of
the container. And because the instance is already authenticated in the turbine API,
all you have to do is call one of the methods to fetch data from an API endpoint:

```php
use \StephaneCoinon\Turbine\Turbine;

$employees = app(Turbine::class)->employees();
```

or use the facade:

```php
use \StephaneCoinon\Turbine\Laravel\Facades\Turbine;

$employees = Turbine::employees();
```

## Tests

`./vendor/bin/phpunit`

## License

This package is open-sourced software licensed under the [MIT license](./LICENSE.md).
