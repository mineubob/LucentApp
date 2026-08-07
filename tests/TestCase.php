<?php

namespace Tests;

use Lucent\Application;
use Lucent\Database;
use Lucent\Database\Migration;
use Lucent\Filesystem\File;
use Lucent\Filesystem\Folder;
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
     * The sqlite database file used by feature tests.
     */
    protected const TEST_DATABASE = '/storage/testing.sqlite';

    /**
     * Point the application at a throwaway sqlite database and migrate the
     * given models, so tests never touch a developer's real database.
     *
     * Uses {@see Application::setEnv()} to switch the in-memory environment
     * to sqlite, so the developer's real .env file is never clobbered.
     *
     * @param array<class-string<\Lucent\Model\Model>> $models
     */
    protected function setUpDatabase(array $models): void
    {
        $storage = new Folder('/storage');

        if (!$storage->exists()) {
            $storage->create(0755);
        }

        $app = Application::getInstance();
        $app->setEnv([
            'DB_DRIVER' => 'sqlite',
            'DB_DATABASE' => self::TEST_DATABASE,
        ]);

        // Recreate the database singleton so it picks up the new config.
        Database::reset();

        // Drop any existing tables so each test starts clean.
        Database::disabling('foreign_key_checks', function () {
            foreach (Database\Schema::list() as $table) {
                $table->drop();
            }
        });

        $migrator = new Migration();

        foreach ($models as $model) {
            if (!$migrator->make($model)) {
                $this->fail("Failed to migrate model {$model}");
            }
        }
    }

    /**
     * Remove the throwaway sqlite file.
     */
    protected function tearDown(): void
    {
        $database = new File(self::TEST_DATABASE);

        if ($database->exists()) {
            $database->delete();
        }

        parent::tearDown();
    }
}
