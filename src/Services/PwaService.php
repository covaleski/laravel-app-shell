<?php

namespace Covaleski\LaravelPwa\Services;

use Covaleski\LaravelPwa\Routing\Registrar;
use Illuminate\Foundation\Application;

class PwaService
{
    /**
     * Create the service instance.
     */
    public function __construct(
        /**
         * Application.
         */
        protected Application $application,
    ) {
        //
    }

    /**
     * Get a new PWA registrar instance.
     */
    public function newPwa(): Registrar
    {
        return $this->application->make(Registrar::class);
    }

    /**
     * Register a new PWA.
     */
    public function register(
        string $entrypoint_view = 'pwa.entrypoint',
        string $route_prefix = 'pwa',
        string $uri = '/app',
    ): void {
        $this->newPwa()
            ->prefixRoutes($route_prefix)
            ->prefixUri($uri)
            ->setEntrypoint($entrypoint_view)
            ->register();
    }
}
