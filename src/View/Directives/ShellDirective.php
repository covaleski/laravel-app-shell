<?php

namespace Covaleski\Laravel\Shelter\View\Directives;

class ShellDirective extends Directive
{
    /**
     * Compile the directive.
     */
    public function compile(string $expression): string
    {
        return <<<PHP
            <?php echo (new \Illuminate\View\ComponentAttributeBag())->merge([
                'id' => 'shell',
                'hx-history-elt' => true,
                'hx-headers' => json_encode(['HX-Current-Shell' => \$shell]),
            ])->merge({$expression}) ?>
            PHP;
    }
}
