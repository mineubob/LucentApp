# Lucent

Starter project template for the [Lucent PHP framework](https://github.com/blueprintau/Lucent).

## Installation

Create a new project with Composer:

```bash
composer create-project blueprintau/lucentapp myapp
```

## Getting started

```bash
cd myapp
vendor/bin/lucent serve
```

## Testing

The project ships with [PHPUnit](https://phpunit.de/) wired up and a small
example test to get you started.

```bash
composer test                # run the full test suite
composer test:unit           # run only the unit testsuite
composer test:coverage       # run with a text coverage report
```

Tests live in `tests/` and use the `Tests\` namespace:

```text
tests/
├── bootstrap.php     # Composer autoloader bootstrap
├── TestCase.php      # Base test case (extend this, not PHPUnit's)
└── Unit/             # Unit tests
```

Write your own tests by extending `Tests\TestCase`:

```php
<?php

namespace Tests\Unit;

use Tests\TestCase;

class MyTest extends TestCase
{
    public function test_something(): void
    {
        $this->assertTrue(true);
    }
}
```

## Structure

```text
myapp/
├── App/
│   ├── Commands/
│   ├── Controllers/
│   ├── Models/
│   └── Rules/
├── commands/        # CLI command definitions
├── routes/          # HTTP route definitions
├── public/          # Web entry point (index.php)
├── storage/         # Application storage
├── logs/            # Log files
├── .env.example     # Environment template
└── composer.json
```

## Entry points

- **HTTP:** `public/index.php`
- **CLI:** `vendor/bin/lucent`

## License

MIT
