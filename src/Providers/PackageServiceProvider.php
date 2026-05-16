<?php

namespace Covaleski\LaravelPwa\Providers;

use Covaleski\LaravelPwa\Routing\Router;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades;
use Illuminate\Support\ServiceProvider;

class PackageServiceProvider extends ServiceProvider
{
    /**
     * Package root path.
     */
    protected string $path;

    /**
     * Create the service provider instance.
     *
     * Adds the package vendor directory path for convenience.
     */
    public function __construct(Application $app)
    {
        $this->path = dirname(dirname(__DIR__));
        return parent::__construct($app);
    }

    /**
     * Register services.
     */
    public function register(): void
    {
        $this->registerConfigs();
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        $this->bootFacadeMacros();
        $this->bootHelperMacros();
        $this->bootBladeDirectives();
        $this->bootAssets();
    }

    /**
     * Bootstrap package assets.
     */
    protected function bootAssets(): void
    {
        $this->mergeConfigFrom(
            "{$this->path}/config/pwa.php",
            'pwa',
        );
        $this->loadRoutesFrom(
            "{$this->path}/routes/web.php",
        );
        $this->loadViewsFrom(
            "{$this->path}/resources/views",
            'pwa',
        );
        $this->publishes([
            "{$this->path}/config/pwa.php" => config_path('pwa.php'),
        ]);
    }

    /**
     * Bootstrap package Blade directives.
     */
    public function bootBladeDirectives(): void
    {
        Facades\Blade::directive('pwaShell', function (string $expression) {
            return <<<PHP
                <?= attributes(
                    ['hx-headers' => '{"HX-Current-Shell": "' . \$shell . '"}'],
                    config('pwa.attributes.shell'),
                    {$expression}
                ) ?>
                PHP;
        });
        Facades\Blade::directive('pwaPage', function (string $expression) {
            return <<<PHP
                <?= attributes(config('pwa.attributes.page'), {$expression}) ?>
                PHP;
        });
    }

    /**
     * Bootstrap package facade macros.
     */
    public function bootFacadeMacros(): void
    {
        Facades\Request::macro('htmx', function () {
            /** @var Request $this */
            return $this->hasHeader('HX-Request');
        });
        Facades\Route::macro('pwa', function (mixed ...$args) {
            $args = array_replace(config('pwa.router', []), $args);
            $router = new Router(...$args);
            $router->route();
        });
    }

    /**
     * Boot package helper macros.
     */
    public function bootHelperMacros(): void
    {
        //
    }

    /**
     * Register package configuration files.
     */
    protected function registerConfigs(): void
    {
        $this->mergeConfigFrom(
            "{$this->path}/config/pwa.php",
            'htmx',
        );
    }
}
