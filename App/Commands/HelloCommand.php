<?php

namespace App\Commands;

/**
 * Example CLI command.
 *
 * Commands are plain classes with public methods. Parameters are matched
 * by name from the command's `{placeholder}` arguments. This class is a
 * starting point — extend it or delete it as you build your application.
 */
class HelloCommand
{
    public function greet(string $name = 'world'): string
    {
        return "Hello, {$name}!";
    }
}