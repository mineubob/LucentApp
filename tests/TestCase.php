<?php

namespace Tests;

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
}
