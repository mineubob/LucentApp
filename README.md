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
cp .env.example .env   # already done automatically by composer create-project
composer serve          # or: vendor/bin/lucent serve
```

## Example code

The template ships with a small, working example so you can see Lucent's
conventions in action. It's safe to delete once you start building.

- **Model** — `App/Models/User.php` declares columns with the `#[Column]`
  attribute. Create its table with:

  ```bash
  vendor/bin/lucent migration make App/Models/User
  ```

- **Controller** — `App/Controllers/UserController.php` shows request
  validation (`Rule::validateRequest`) and route model binding (a
  type-hinted model parameter is resolved from the matching route
  placeholder, returning a 404 if missing). Controllers return PSR-7
  `Response` objects.

- **Middleware** — `App/Middleware/RequestLogger.php` shows a PSR-15
  middleware (logs each request, adds a response header). It's attached to
  the route group via `->middleware([RequestLogger::class])`.

- **Routes** — `routes/api.php` registers a REST-style group:

  ```bash
  curl -X POST http://localhost:8000/user/create -d 'name=Jane&email=jane@example.com'
  curl http://localhost:8000/user/1
  ```

- **CLI command** — `App/Commands/HelloCommand.php` registered in
  `commands/hello.php`. Note that Lucent CLI commands don't support
  optional/default arguments, so a no-arg `hello` and a `hello {name}`
  variant are registered separately:

  ```bash
  vendor/bin/lucent hello
  vendor/bin/lucent hello Lucent
  ```

## Testing

The project ships with [PHPUnit](https://phpunit.de/) wired up, plus example
unit and feature tests to get you started.

```bash
composer test                # run the full test suite
composer test:unit           # run only the unit testsuite
composer test:feature        # run only the feature testsuite
composer test:coverage       # run with a text coverage report
```

Tests live in `tests/` and use the `Tests\` namespace:

```text
tests/
├── bootstrap.php     # Composer autoloader bootstrap
├── TestCase.php      # Base test case (extend this, not PHPUnit's)
├── Unit/             # Unit tests
└── Feature/          # Feature tests (HTTP requests against a sqlite DB)
```

Feature tests dispatch real HTTP requests through the application against a
throwaway sqlite database, so they never touch your real database. The
`Tests\TestCase::setUpDatabase()` helper migrates the models you pass it.

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
├── tests/           # PHPUnit tests (Unit + Feature)
├── .env.example     # Environment template
├── .editorconfig    # Editor/IDE conventions
├── .gitattributes   # Git attributes & archive exclusions
└── composer.json
```

## Entry points

- **HTTP:** `public/index.php`
- **CLI:** `vendor/bin/lucent`

## License

MIT
