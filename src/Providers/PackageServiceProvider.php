<?php

namespace Covaleski\LaravelPwa\Providers;

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
        $this->mergeConfigFrom(
            "{$this->path}/config/pwa.php",
            'pwa',
        );
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        $this->bootFacadeMacros();
        $this->bootHelperMacros();
        $this->bootBlade();
        $this->bootAssets();
    }

    /**
     * Bootstrap package assets.
     */
    protected function bootAssets(): void
    {
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
    public function bootBlade(): void
    {
        Facades\Blade::anonymousComponentPath(
            "{$this->path}/resources/views/components",
            'pwa',
        );
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
    }

    /**
     * Boot package helper macros.
     */
    public function bootHelperMacros(): void
    {
        //
    }
}
