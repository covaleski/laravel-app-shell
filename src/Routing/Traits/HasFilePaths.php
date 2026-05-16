<?php

namespace Covaleski\LaravelPwa\Routing\Traits;

trait HasFilePaths
{
    /**
     * File path prefix.
     */
    protected string $filePrefix;

    /**
     * Prefix a relative file with the current file path.
     */
    protected function prefixFilePath(string $path): string
    {
        return $this->filePrefix
            . DIRECTORY_SEPARATOR
            . $this->trimRoutePath($path);
    }

    /**
     * Remove leading and trailing separators from a file path.
     */
    protected function trimFilePath(string $path): string
    {
        return rtrim($path, '\\/');
    }
}
