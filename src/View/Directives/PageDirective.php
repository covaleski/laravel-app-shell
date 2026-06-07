<?php

namespace Covaleski\LaravelAppShell\View\Directives;

class PageDirective extends Directive
{
    /**
     * Compile the directive.
     */
    public function compile(string $expression): string
    {
        return <<<PHP
            <?php echo (new \Illuminate\View\ComponentAttributeBag([
                'id' => 'page',
            ]))->merge({$expression}) ?>
            PHP;
    }
}
