<?php

namespace Covaleski\LaravelPwa\Providers;

use Covaleski\LaravelPwa\Routing\PageRouter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades;
use Illuminate\Support\ServiceProvider;

class HelperServiceProvider extends ServiceProvider
{
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
        Facades\Request::macro('htmx', function () {
            /** @var Request $this */
            return $this->hasHeader('HX-Request');
        });
        Facades\Route::macro('pwa', function (mixed ...$args) {
            $args = array_replace(config('pwa.router', []), $args);
            $router = new PageRouter(...$args);
            $router->route();
        });
    }
}
