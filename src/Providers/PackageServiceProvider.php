<?php

namespace Covaleski\LaravelAppShell\Providers;

use Covaleski\LaravelAppShell\Http\Middleware;
use Illuminate\Foundation\Application;
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
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        $this->loadViewsFrom(
            "{$this->path}/resources/views",
            'app-shell',
        );
        Facades\Blade::anonymousComponentPath(
            "{$this->path}/resources/views/components",
            'app-shell',
        );
        Facades\Route::aliasMiddleware(
            'with-entrypoint',
            Middleware\EnforceEntrypoint::class,
        );
        Facades\Route::aliasMiddleware(
            'with-shell',
            Middleware\EnforceShell::class,
        );
    }
}
