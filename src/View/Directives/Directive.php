<?php

namespace Covaleski\Laravel\Shelter\View\Directives;

abstract class Directive implements DirectiveInterface
{
    /**
     * Call the directive as a function.
     *
     * Compiles the directive.
     */
    public function __invoke(string $expression): string
    {
        return $this->compile($expression);
    }
}
