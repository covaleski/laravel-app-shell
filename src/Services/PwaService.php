<?php

namespace Covaleski\LaravelPwa\Services;

use Covaleski\LaravelPwa\Routing\Router;
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
    public function newPwa(): Router
    {
        return $this->application->make(Router::class);
    }
}
