<?php

namespace Covaleski\LaravelPwa\Support\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static \Covaleski\LaravelPwa\Routing\Registrar newPwa()
 * @method static void register(string $entrypoint_view = 'pwa.entrypoint', string $route_prefix = 'pwa', string $uri = '/app')
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
