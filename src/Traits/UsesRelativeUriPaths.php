<?php

namespace Covaleski\LaravelPwa\Traits;

trait UsesRelativeUriPaths
{
    /**
     * URI path prefix.
     */
    protected string $uriPrefix;

    /**
     * Prefix a relative URI with the current URI path.
     */
    protected function prefixUriPath(string $path): string
    {
        return $this->uriPrefix . '/' . $this->trimUriPath($path);
    }

    /**
     * Remove leading and trailing separators from a URI path.
     */
    protected function trimUriPath(string $path): string
    {
        return trim($path, '/');
    }
}
