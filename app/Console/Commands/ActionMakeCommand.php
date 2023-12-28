<?php

namespace App\Console\Commands;

use Illuminate\Console\GeneratorCommand;


class ActionMakeCommand extends GeneratorCommand
{
    protected $signature = 'make:action {name}';

    protected $description = 'Create a new action class';

    protected $type = 'Action';

    protected function getStub(): string
    {
        return __DIR__ . '/stubs/action.stub';
    }

    protected function getDefaultNamespace($rootNamespace): string
    {
        return $rootNamespace . '\Actions';
    }
}
