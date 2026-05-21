<?php

namespace Covaleski\LaravelPwa\Providers;

use Covaleski\LaravelPwa\Http\Middleware;
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
            'pwa',
        );
        Facades\Blade::anonymousComponentPath(
            "{$this->path}/resources/views/components",
            'pwa',
        );
        Facades\Route::aliasMiddleware(
            'pwa',
            Middleware\FilterPwaRequest::class,
        );
        Facades\Route::aliasMiddleware(
            'pwa.shell',
            Middleware\FormatAppShellResponse::class,
        );
    }
}
