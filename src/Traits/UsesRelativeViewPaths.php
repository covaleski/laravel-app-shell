<?php

namespace Covaleski\LaravelPwa\Traits;

trait UsesRelativeViewPaths
{
    /**
     * View name prefix.
     */
    protected string $viewPrefix;

    /**
     * Prefix a relative view name with the root view path.
     */
    protected function prefixViewPath(string $view): string
    {
        return $this->viewPrefix . '.' . trim($view, '.');
    }

    /**
     * Remove leading and trailing separators from a view path.
     */
    protected function trimViewPath(string $path): string
    {
        return trim($path, '.');
    }
}
