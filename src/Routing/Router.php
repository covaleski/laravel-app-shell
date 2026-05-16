<?php

namespace Covaleski\LaravelPwa\Routing;

use Closure;
use Covaleski\LaravelPwa\Routing\Traits\HasRoutePaths;
use Covaleski\LaravelPwa\Routing\Traits\HasUriPaths;
use Covaleski\LaravelPwa\Routing\Traits\HasViewPaths;
use Illuminate\Routing\Route;

class Router
{
    use HasRoutePaths, HasUriPaths, HasViewPaths;

    /**
     * Base directory for the PWA page views.
     */
    protected string $directory;

    /**
     * Entrypoint view name.
     */
    protected string $entrypointView;

    /**
     * Create the router instance.
     */
    public function __construct(
        /**
         * Prefix for the PWA route names.
         */
        string $route_prefix,

        /**
         * Initial URI path for the PWA.
         */
        string $uri,

        /**
         * Base path for the PWA page views.
         */
        string $view_root,
    ) {
        $this->routePrefix = $this->trimRoutePath($route_prefix);
        $this->uriPrefix = $this->trimUriPath($uri);
        $this->viewPrefix = $this->trimViewPath($view_root);
        $this->entrypointView = $this->resolveEntrypointView();
        $this->directory = $this->resolveDirectory($this->entrypointView);
    }

    /**
     * Add all necessary routes to the application.
     */
    public function route(): void
    {
        $this->routeDirectory(tap(new Directory(
            file_path: $this->directory,
            entrypointView: $this->entrypointView,
            manifest: tap(new Manifest(
                file_path: $this->directory,
                route_path: $this->routePrefix,
                uri_path: $this->uriPrefix,
            ), $this->routeManifest(...)),
            route_name: $this->routePrefix,
            uri_path: $this->uriPrefix,
            view_path: $this->viewPrefix,
        ), $this->routeFallback(...)));
    }

    /**
     * Add a route to the application.
     */
    public function addRoute(
        string $uri,
        Closure $callback,
        string $route_name,
        array $middleware = [],
        array $where = [],
    ): Route {
        return app('router')
            ->any($uri, $callback)
            ->name($route_name)
            ->where($where)
            ->middleware($middleware);
    }

    /**
     * Get the router's initial directory.
     */
    protected function resolveDirectory(string $entrypoint_view): string
    {
        /** @var \Illuminate\View\View */
        $view = view($entrypoint_view);
        return dirname($view->getPath());
    }

    /**
     * Get the entrypoint view.
     */
    protected function resolveEntrypointView(): string
    {
        return $this->prefixViewPath('entrypoint');
    }

    /**
     * Add a route for the application manifest file.
     */
    protected function routeManifest(Manifest $manifest): void
    {
        $this->addRoute(
            uri: $manifest->getUri(),
            callback: $manifest->getCallback(),
            route_name: $manifest->getRouteName(),
        );
    }

    /**
     * Add routes for pages in the specified directory, recursively.
     */
    protected function routeDirectory(Directory $directory): void
    {
        if ($directory->hasPage()) {
            $this->addRoute(
                uri: $directory->getUri(),
                route_name: $directory->getRouteName(),
                callback: $directory->getCallback(),
                middleware: $directory->getMiddleware(),
                where: $directory->getWhere(),
            );
        }
        foreach ($directory->getDirectories() as $subdirectory) {
            $this->routeDirectory($subdirectory);
        }
    }

    /**
     * Add a fallback route for the application.
     */
    protected function routeFallback(Directory $directory): void
    {
        $this->addRoute(
            uri: $directory->getFallbackUri(),
            route_name: $directory->getRouteName(),
            callback: $directory->getFallbackCallback(),
            middleware: $directory->getMiddleware(),
            where: $directory->getWhere(),
        )->fallback();
    }
}
