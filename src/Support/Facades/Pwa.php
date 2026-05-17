<?php

namespace Covaleski\LaravelPwa\Support\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static \Covaleski\LaravelPwa\Routing\Registrar newPwa()
 * @method static void register(string $entrypoint_view, string $route_prefix, string $uri)
 *
 * @see \Covaleski\LaravelPwa\Services\PwaService
 */
class Pwa extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return \Covaleski\LaravelPwa\Services\PwaService::class;
    }
}
