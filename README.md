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

## Structure

```
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
