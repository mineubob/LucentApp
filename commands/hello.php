<?php

use App\Commands\HelloCommand;
use Lucent\Facades\CommandLine;

// Register custom CLI commands here. Files in this directory are
// auto-loaded on boot.
//
// Note: Lucent CLI commands don't support optional/default arguments — a
// `{placeholder}` must be provided. Register a separate no-arg command if
// you want a default.
CommandLine::register('hello', 'greet', HelloCommand::class, 'Say hello');
CommandLine::register('hello {name}', 'greet', HelloCommand::class, 'Say hello to someone');