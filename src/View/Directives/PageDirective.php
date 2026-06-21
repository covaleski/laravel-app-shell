<?php

namespace Covaleski\Laravel\Shelter\View\Directives;

class PageDirective extends Directive
{
    /**
     * Compile the directive.
     */
    public function compile(string $expression): string
    {
        return <<<PHP
            <?php echo (new \Illuminate\View\ComponentAttributeBag())->merge([
                'id' => 'page',
            ])->merge({$expression}) ?>
            PHP;
    }
}
