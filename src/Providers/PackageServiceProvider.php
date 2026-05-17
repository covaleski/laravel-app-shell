<?php

namespace Covaleski\LaravelPwa\Providers;

use Covaleski\LaravelPwa\Services;
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
     * All of the container singletons that should be registered.
     *
     * @var array<string, string>
     */
    public array $singletons = [
        Services\PwaService::class => Services\PwaService::class,
    ];

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
        $this->loadViewsFrom(
            "{$this->path}/resources/views",
            'pwa',
        );
        $this->publishes([
            "{$this->path}/config/pwa.php" => config_path('pwa.php'),
        ]);
        Facades\Blade::anonymousComponentPath(
            "{$this->path}/resources/views/components",
            'pwa',
        );
        Facades\Request::macro('htmx', function () {
            /** @var Request $this */
            return $this->hasHeader('HX-Request');
        });
    }
}
