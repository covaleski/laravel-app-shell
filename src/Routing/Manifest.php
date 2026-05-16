<?php

namespace Covaleski\LaravelPwa\Routing;

use Closure;
use Covaleski\LaravelPwa\Routing\Traits\HasFilePaths;
use Covaleski\LaravelPwa\Routing\Traits\HasRoutePaths;
use Covaleski\LaravelPwa\Routing\Traits\HasUriPaths;

class Manifest
{
    use HasFilePaths, HasRoutePaths, HasUriPaths;

    /**
     * Resolved manifest data.
     */
    protected array $data;

    /**
     * Create the manifest instance.
     */
    public function __construct(
        string $file_path,
        string $route_path,
        string $uri_path,
    ) {
        $this->filePrefix = $this->trimFilePath($file_path);
        $this->routePrefix = $this->trimRoutePath($route_path);
        $this->uriPrefix = $this->trimUriPath($uri_path);
        $this->data = $this->resolveData();
    }

    /**
     * Get the manifest file route callback.
     */
    public function getCallback(): Closure
    {
        return function () {
            return response()->json($this->getData(), 200, [
                'Content-Type' => 'application/manifest+json',
            ]);
        };
    }

    /**
     * Get the manifest data.
     */
    public function getData(): array
    {
        return $this->data;
    }

    /**
     * Get the manifest file route name.
     */
    public function getRouteName(): string
    {
        return $this->prefixRoutePath('manifest');
    }

    /**
     * Get the manifest file route URI.
     */
    public function getUri(): string
    {
        return $this->prefixUriPath('app.webmanifest');
    }

    /**
     * Load the manifest data.
     */
    protected function resolveData(): array
    {
        return require $this->prefixFilePath('manifest.php');
    }
}
