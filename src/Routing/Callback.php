<?php

namespace Covaleski\LaravelPwa\Routing;

use Covaleski\LaravelPwa\View\Page;
use Illuminate\Http\Request;
use Throwable;

class Callback
{
    /**
     * Create the callback instance.
     */
    public function __construct(
        /**
         * Entrypoint view name.
         */
        protected string $entrypointView,

        /**
         * Error view name.
         */
        protected string $errorView,

        /**
         * Manifest route name.
         */
        protected string $manifestRoute,

        /**
         * Page view name.
         */
        protected string $pageView,

        /**
         * Shell view name.
         */
        protected string $shellView,
    ) {
        //
    }

    /**
     * Call the object as a function.
     */
    public function __invoke(Request $request): mixed
    {
        return $request->htmx() ? $this->respondHtmx() : $this->respondHtml();
    }

    /**
     * Respond a default HTML request.
     */
    protected function respondHtml(): mixed
    {
        return view(
            $this->entrypointView,
            ['manifest' => route($this->manifestRoute)],
        );
    }

    /**
     * Respond an HTML request that has the `HX-Request` header.
     */
    protected function respondHtmx(): mixed
    {
        try {
            return new Page(
                $this->pageView,
                $this->shellView,
            );
        } catch (Throwable $exception) {
            return new Page(
                $this->errorView,
                $this->shellView,
                ['error' => $exception],
            );
        }
    }
}
