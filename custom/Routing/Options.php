<?php

namespace Covaleski\LaravelPwa\Routing;

class Options
{
    /**
     * Create the options object instance.
     */
    public function __construct(
        /**
         * Middleware.
         */
        public array $middleware = [],

        /**
         * Route parameter conditions.
         */
        public array $where = [],
    ) {
        //
    }

    /**
     * Get a clone of this instance.
     */
    public function clone(): static
    {
        return clone $this;
    }

    /**
     * Merge the specified directory options with the current one.
     */
    public function merge(Options $options): static
    {
        $merged = $this->clone();
        $merged->middleware = array_unique(
            array_merge(
                $merged->middleware,
                $options->middleware,
            ),
        );
        $merged->where = array_replace(
            $merged->where,
            $options->where,
        );
        return $merged;
    }
}
