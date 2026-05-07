<?php

namespace Covaleski\LaravelPwa\Routing;

use Closure;
use Covaleski\LaravelPwa\Routing\Traits\HasFilePaths;
use Covaleski\LaravelPwa\Routing\Traits\HasRoutePaths;
use Covaleski\LaravelPwa\Routing\Traits\HasUriPaths;
use Covaleski\LaravelPwa\Routing\Traits\HasViewPaths;
use Covaleski\LaravelPwa\View\Page;
use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use RuntimeException;

class Directory
{
    use HasFilePaths, HasRoutePaths, HasUriPaths, HasViewPaths;

    /**
     * Resolved directory options.
     */
    protected object $options;

    /**
     * Resolved page view name.
     */
    protected string $page;

    /**
     * Resolved shell view name.
     */
    protected string $shell;

    /**
     * Create the directory instance.
     */
    public function __construct(
        /**
         * Directory full path.
         */
        protected string $file_path,

        /**
         * Entrypoint view name.
         */
        protected string $entrypointView,

        /**
         * Manifest object.
         */
        protected Manifest $manifest,

        /**
         * Page route name.
         */
        protected string $route_name,

        /**
         * Page URI path.
         */
        protected string $uri_path,

        /**
         * Directory view path.
         */
        protected string $view_path,

        /**
         * Inherited directory options.
         */
        protected ?Options $parentOptions = null,

        /**
         * Inherited shell view name.
         */
        protected ?string $parentShell = null,
    ) {
        $this->filePrefix = $this->trimFilePath($file_path);
        $this->routePrefix = $this->trimRoutePath($route_name);
        $this->uriPrefix = $this->trimUriPath($uri_path);
        $this->viewPrefix = $this->trimViewPath($view_path);
        $this->options = $this->resolveOptions();
        $this->page = $this->resolvePage();
        $this->shell = $this->resolveShell();
    }

    /**
     * Get the page route callback.
     */
    public function getCallback(): Closure
    {
        return function (Request $request) {
            if ($request->htmx()) {
                return new Page($this->page, $this->shell);
            } else {
                $manifest = route($this->manifest->getRouteName());
                return view($this->entrypointView, compact('manifest'));
            }
        };
    }

    /**
     * Get all subdirectories as directory objects.
     *
     * @return array<static>
     */
    public function getDirectories(): array
    {
        return array_map(
            fn (string $directory) => new static(
                file_path: $this->prefixFilePath($directory),
                entrypointView: $this->entrypointView,
                manifest: $this->manifest,
                route_name: $this->prefixRoutePath($directory),
                uri_path: $this->formatUriSegment($directory),
                view_path: $this->prefixViewPath($directory),
                parentOptions: $this->options,
                parentShell: $this->shell,
            ),
            $this->getFilesystem()->directories(),
        );
    }

    /**
     * Get the page route middleware.
     */
    public function getMiddleware(): array
    {
        return $this->options->middleware ?? [];
    }

    /**
     * Get the page route name.
     */
    public function getRouteName(): string
    {
        return $this->routePrefix;
    }

    /**
     * Get the page route URI.
     */
    public function getUri(): string
    {
        return $this->uriPrefix;
    }

    /**
     * Get the page route parameter conditions.
     */
    public function getWhere(): array
    {
        return $this->options->where ?? [];
    }

    /**
     * Check whether the directory has a page view.
     */
    public function hasPage(): bool
    {
        return view()->exists($this->page);
    }

    /**
     * Format a directory name as a route URI segment.
     */
    protected function formatUriSegment(string $segment): string
    {
        return str($segment)
            ->replaceMatches('/^\[(.+)\]$/', '{$1}')
            ->pipe($this->prefixUriPath(...))
            ->toString();
    }

    /**
     * Get a filesystem object for the directory path.
     */
    protected function getFilesystem(): Filesystem
    {
        return Storage::build(['driver' => 'local', 'root' => $this->filePrefix]);
    }

    /**
     * Load the directory options in the specified filename.
     */
    protected function loadOptions(string $filename): ?object
    {
        return file_exists($filename) ? require $filename : null;
    }

    /**
     * Get the final options for the directory.
     *
     * Merges parent directory options.
     */
    protected function resolveOptions(): Options
    {
        if (file_exists($file = $this->prefixFilePath('options.php'))) {
            $options = require $file;
            return $this->parentOptions?->merge($options) ?? $options;
        } else {
            return $this->parentOptions?->clone() ?? new Options();
        }
    }

    /**
     * Get the page view name.
     */
    protected function resolvePage(): string
    {
        return $this->prefixViewPath('page');
    }

    /**
     * Get the shell view name.
     */
    protected function resolveShell(): string
    {
        return $this->validateShell($this->prefixViewPath('shell'));
    }

    /**
     * Check if a shell view exists and return its name or the parent view name.
     *
     * Throws an exception if can't find any of those shells.
     */
    protected function validateShell(string $view): string
    {
        if (view()->exists($view)) {
            return $view;
        } elseif ($this->parentShell) {
            return $this->parentShell;
        } else {
            throw new RuntimeException('Shell not found');
        }
    }
}
