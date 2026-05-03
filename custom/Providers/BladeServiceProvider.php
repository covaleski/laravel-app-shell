<?php

namespace Covaleski\LaravelPwa\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class BladeServiceProvider extends ServiceProvider
{
    /**
     * Path for Blade views.
     */
    protected string $path;

    /**
     * Create the service provider instance.
     */
    public function __construct($app)
    {
        $this->path = dirname(dirname(__DIR__)) . '/resources/views';
        return parent::__construct($app);
    }

    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        Blade::directive('pwaLink', function (string $expression) {
            return <<<PHP
                <?php attributes([
                    'hx-get' => {$expression},
                    'hx-push-url' => 'true',
                ]); ?>
                PHP;
        });
        Blade::directive('pwaShell', function (string $expression) {
            return <<<PHP
                <?= attributes(
                    ['hx-headers' => '{"HX-Current-Shell": "' . \$shell . '"}'],
                    config('pwa.attributes.shell'),
                    {$expression}
                ) ?>
                PHP;
        });
        Blade::directive('pwaPage', function (string $expression) {
            return <<<PHP
                <?= attributes(config('pwa.attributes.page'), {$expression}) ?>
                PHP;
        });
    }
}
