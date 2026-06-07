<?php

namespace Covaleski\LaravelAppShell\View\Directives;

interface DirectiveInterface
{
    /**
     * Call the directive as a function.
     *
     * Compiles the directive.
     */
    public function __invoke(string $expression): string;

    /**
     * Compile the directive.
     */
    public function compile(string $expression): string;
}
