<?php

namespace Tests;

use Lucent\Application;
use Lucent\Database;
use Lucent\Database\Migration;
use PHPUnit\Framework\TestCase as PHPUnitTestCase;

/**
 * Base test case for all application tests.
 *
 * Extend this class (rather than PHPUnit's TestCase directly) so you
 * can add shared helpers and setup logic as your suite grows — e.g.
 * database seeding, request faking, or application bootstrapping.
 */
abstract class TestCase extends PHPUnitTestCase
{
    /**
     * Use an in-memory sqlite database so tests never touch a developer's
     * real database and leave no files behind.
     */
    protected const TEST_DATABASE = ':memory:';

    /**
     * Point the application at an in-memory sqlite database and migrate the
     * given models, so tests never touch a developer's real database.
     *
     * Uses {@see Application::setEnv()} to switch the in-memory environment
     * to sqlite, so the developer's real .env file is never clobbered.
     *
     * Each call resets the connection pool, so the next getInstance() boots a
     * fresh in-memory connection — giving every test a clean, empty database
     * with no file I/O and nothing to clean up afterwards.
     *
     * @param array<class-string<\Lucent\Model\Model>> $models
     */
    protected function setUpDatabase(array $models): void
    {
        $app = Application::getInstance();
        $app->setEnv([
            'DB_DRIVER' => 'sqlite',
            'DB_DATABASE' => self::TEST_DATABASE,
        ]);

        // Recreate the database singleton so it picks up the new config.
        // Closing the previous in-memory connection discards its data, so
        // each test starts with a fresh, empty database.
        Database::reset();

        $migrator = new Migration();

        foreach ($models as $model) {
            if (!$migrator->make($model)) {
                $this->fail("Failed to migrate model {$model}");
            }
        }
    }
}
