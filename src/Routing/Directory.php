<?php

namespace Covaleski\LaravelPwa\Routing;

use Closure;
use Covaleski\LaravelPwa\Traits\UsesRelativeFilePaths;
use Covaleski\LaravelPwa\Traits\UsesRelativeRoutePaths;
use Covaleski\LaravelPwa\Traits\UsesRelativeUriPaths;
use Covaleski\LaravelPwa\Traits\UsesRelativeViewPaths;
use Covaleski\LaravelPwa\View\Page;
use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpKernel\Exception\NotAcceptableHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class Directory
{
    use UsesRelativeFilePaths;
    use UsesRelativeRoutePaths;
    use UsesRelativeUriPaths;
    use UsesRelativeViewPaths;

    /**
     * Resolved error view name.
     */
    protected string $errorView;

    /**
     * Resolved directory options.
     */
    protected object $options;

    /**
     * Resolved page view name.
     */
    protected string $pageView;

    /**
     * Resolved shell view name.
     */
    protected string $shellView;

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
         * Inherited error view name.
         */
        protected string $parentErrorView = 'pwa::error',

        /**
         * Inherited directory options.
         */
        protected ?Options $parentOptions = null,

        /**
         * Inherited shell view name.
         */
        protected string $parentShellView = 'pwa::shell',
    ) {
        $this->filePrefix = $this->trimFilePath($file_path);
        $this->routePrefix = $this->trimRoutePath($route_name);
        $this->uriPrefix = $this->trimUriPath($uri_path);
        $this->viewPrefix = $this->trimViewPath($view_path);
        $this->errorView = $this->resolveErrorView();
        $this->options = $this->resolveOptions();
        $this->pageView = $this->resolvePageView();
        $this->shellView = $this->resolveShellView();
    }

    /**
     * Get the page route callback.
     */
    public function getCallback(): Closure
    {
        return $this->makeCallback(function () {
            return new Page($this->pageView, $this->shellView);
        });
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
                parentErrorView: $this->errorView,
                parentOptions: $this->options,
                parentShellView: $this->shellView,
            ),
            $this->getFilesystem()->directories(),
        );
    }

    /**
     * Get the fallback route callback.
     */
    public function getFallbackCallback(): Closure
    {
        return $this->makeCallback(function () {
            throw new NotFoundHttpException();
        });
    }

    /**
     * Get the fallback route URI.
     */
    public function getFallbackUri(): string
    {
        return $this->prefixUriPath('{path?}');
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
     * Check whether the directory UsesRelative a page view.
     */
    public function UsesRelativePage(): bool
    {
        return view()->exists($this->pageView);
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
     * Create a route callback that handles content negotiation.
     */
    protected function makeCallback(Closure $callback): Closure
    {
        return function (Request $request) use ($callback) {
            if (!$request->acceptsHtml()) {
                throw new NotAcceptableHttpException(
                    headers: [],
                );
            } elseif ($request->htmx()) {
                try {
                    return app()->call($callback);
                } catch (Throwable $error) {
                    return new Page($this->errorView, $this->shellView, [
                        'error' => $error,
                    ]);
                }
            } else {
                return view($this->entrypointView, [
                    'manifest' => route($this->manifest->getRouteName()),
                ]);
            }
        };
    }

    /**
     * Get the error view name.
     */
    protected function resolveErrorView(): string
    {
        if (view()->exists($view = $this->prefixViewPath('error'))) {
            return $view;
        } else {
            return $this->parentErrorView;
        }
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
    protected function resolvePageView(): string
    {
        return $this->prefixViewPath('page');
    }

    /**
     * Get the shell view name.
     */
    protected function resolveShellView(): string
    {
        if (view()->exists($view = $this->prefixViewPath('shell'))) {
            return $view;
        } else {
            return $this->parentShellView;
        }
    }
}
