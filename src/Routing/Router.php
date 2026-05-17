<?php

namespace Covaleski\LaravelPwa\Routing;

use Closure;
use Covaleski\LaravelPwa\Traits\UsesRelativeRoutePaths;
use Covaleski\LaravelPwa\Traits\UsesRelativeUriPaths;
use Covaleski\LaravelPwa\Traits\UsesRelativeViewPaths;
use Illuminate\Routing\Route;
use RuntimeException;

class Router
{
    use UsesRelativeRoutePaths;
    use UsesRelativeUriPaths;
    use UsesRelativeViewPaths;

    /**
     * Base directory for the PWA page views.
     */
    protected string $directory;

    /**
     * Entrypoint view name.
     */
    protected string $entrypointView;

    /**
     * Set the prefix for PWA route names.
     *
     * The PWA routes will be named `$prefix` + `".path.to.route"`.
     */
    public function prefixRoutes(string $prefix): static
    {
        $this->routePrefix = $this->trimRoutePath($prefix);
        return $this;
    }

    /**
     * Set the prefix for PWA URI paths.
     *
     * The PWA actions will be routed as `$prefix` + `"/path/to/page"`.
     */
    public function prefixUri(string $prefix): static
    {
        $this->uriPrefix = $this->trimUriPath($prefix);
        return $this;
    }

    /**
     * Set the prefix for PWA view paths.
     *
     * The PWA actions will be routed as `$prefix` + `".path.to.view"`.
     */
    public function prefixViews(string $prefix): static
    {
        $this->viewPrefix = $this->trimViewPath($prefix);
        return $this;
    }

    /**
     * Add all necessary routes to the application.
     */
    public function route(): void
    {
        $file_path = $this->directory ?? $this->findDirectory();
        $view_path = $this->viewPrefix ?? $this->findViewPrefix();
        $this->routeDirectory(tap(new Directory(
            file_path: $file_path,
            entrypointView: $this->entrypointView,
            manifest: tap(new Manifest(
                file_path: $file_path,
                route_path: $this->routePrefix,
                uri_path: $this->uriPrefix,
            ), $this->routeManifest(...)),
            route_name: $this->routePrefix,
            uri_path: $this->uriPrefix,
            view_path: $view_path,
        ), $this->routeFallback(...)));
    }

    /**
     * Set the PWA root directory path for recursive routing.
     */
    public function setDirectory(string $directory): static
    {
        $this->directory = $directory;
        return $this;
    }

    /**
     * Sets the entrypoint view of the PWA.
     *
     * Uses the entrypoint directory for recursive routing by default.
     */
    public function setEntrypoint(string $view): static
    {
        $this->entrypointView = $view;
        return $this;
    }

    /**
     * Add a route to the application.
     */
    protected function addRoute(
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
     * Get the router's directory using the entrypoint view file.
     */
    protected function findDirectory(): string
    {
        $view = view($this->entrypointView);
        if (!($view instanceof \Illuminate\View\View)) {
            throw new RuntimeException('Expected entrypoint to be a view');
        }
        return dirname($view->getPath());
    }

    /**
     * Get the router's view prefix using the entrypoint view file.
     */
    protected function findViewPrefix(): string
    {
        return str($this->entrypointView)->beforeLast('.')->toString();
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
