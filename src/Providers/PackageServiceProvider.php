<?php

namespace Covaleski\LaravelAppShell\Providers;

use Covaleski\LaravelAppShell\Http\Middleware;
use Covaleski\LaravelAppShell\View\Directives\PageDirective;
use Covaleski\LaravelAppShell\View\Directives\ShellDirective;
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
        $this->publishes(
            $this->getPublishables(),
            'laravel-app-shell',
        );
        Facades\Blade::anonymousComponentPath(
            "{$this->path}/resources/views/components",
            'app-shell',
        );
        Facades\Blade::directive(
            'page',
            $this->app->make(PageDirective::class),
        );
        Facades\Blade::directive(
            'shell',
            $this->app->make(ShellDirective::class),
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

    /**
     * Get assets that can be published via the `vendor:publish` command.
     */
    protected function getPublishables(): array
    {
        return [
            "{$this->path}/resources/views" => resource_path('views/vendor/laravel-app-shell'),
        ];
    }
}
