<?php

namespace Tests\Unit;

use Tests\TestCase;

/**
 * Example test — the starting point for your application's test suite.
 *
 * This is deliberately minimal: it exists to prove PHPUnit is wired up
 * correctly, and to show the shape of a test. Replace it (or add to it)
 * as you build out your application.
 */
class ExampleTest extends TestCase
{
    public function test_application_is_configured(): void
    {
        // Sanity check that the composer autoloader is wired correctly,
        // since this test class itself extends Tests\TestCase.
        $this->assertInstanceOf(
            \PHPUnit\Framework\TestCase::class,
            $this,
        );
    }

    public function test_environment_php_version_is_supported(): void
    {
        // Lucent requires PHP >= 8.4 — fail loudly if the runtime is older.
        $this->assertTrue(
            version_compare(PHP_VERSION, '8.4.0', '>='),
            sprintf('PHP %s is not supported; Lucent requires PHP >= 8.4', PHP_VERSION),
        );
    }
}
