<?php

namespace Covaleski\LaravelPwa\Routing\Traits;

trait HasRoutePaths
{
    /**
     * Route name prefix.
     */
    protected string $routePrefix;

    /**
     * Prefix a relative route name with the route prefix.
     */
    protected function prefixRoutePath(string $route): string
    {
        return $this->routePrefix . '.' . trim($route, '.');
    }

    /**
     * Remove leading and trailing separators from a route path.
     */
    protected function trimRoutePath(string $path): string
    {
        return trim($path, '.');
    }
}
