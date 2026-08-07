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
     * Backup of the developer's real .env, restored in tearDown().
     */
    private ?string $envBackup = null;

    /**
     * Point the application at a throwaway sqlite database and migrate the
     * given models, so tests never touch a developer's real database.
     *
     * The developer's real .env is backed up first and restored in
     * tearDown(), so it is never clobbered by a test run.
     *
     * @param array<class-string<\Lucent\Model\Model>> $models
     */
    protected function setUpDatabase(array $models): void
    {
        $storage = new Folder('/storage');

        if (!$storage->exists()) {
            $storage->create(0755);
        }

        $env = new File(DIRECTORY_SEPARATOR . '.env');

        // Back up the developer's real .env so we can restore it later.
        $this->envBackup = $env->exists() ? $env->getContents() : null;

        $content = "DB_DRIVER=sqlite\nDB_DATABASE=" . self::TEST_DATABASE . "\n";

        $written = $env->exists() ? $env->write($content) : $env->create($content);

        if (!$written) {
            $this->fail('Failed to write test .env file');
        }

        $app = Application::getInstance();
        $app->loadEnv();

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
     * Remove the throwaway sqlite file and restore the developer's .env.
     */
    protected function tearDown(): void
    {
        $database = new File(self::TEST_DATABASE);

        if ($database->exists()) {
            $database->delete();
        }

        // Restore the developer's real .env (or remove the test one if
        // there was no .env to begin with).
        $env = new File(DIRECTORY_SEPARATOR . '.env');

        if ($this->envBackup === null) {
            if ($env->exists()) {
                $env->delete();
            }
        } elseif ($env->exists()) {
            $env->write($this->envBackup);
        }

        parent::tearDown();
    }
}
