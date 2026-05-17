<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default Charset
    |--------------------------------------------------------------------------
    |
    | Some Description
    |
    */

    'charset' => 'UTF-8',

    /*
    |--------------------------------------------------------------------------
    | Default HTMX Script Location
    |--------------------------------------------------------------------------
    |
    | This option defines the default HTMX script URL.
    |
    */

    'htmx' => 'https://cdn.jsdelivr.net/npm/htmx.org@2.0.10/dist/htmx.min.js',

    /*
    |--------------------------------------------------------------------------
    | Default Page Router Parameters
    |--------------------------------------------------------------------------
    |
    | This option defines the default parameters when creating a page router
    | instance from the `Route::pwa(...)` method.
    |
    */

    'router' => [
        'route_prefix' => 'pwa',
        'uri' => '/app',
        'view_root' => 'pwa',
    ],

    /*
    |--------------------------------------------------------------------------
    | Default Viewport Directive
    |--------------------------------------------------------------------------
    |
    | Some Description
    |
    */

    'viewport' => 'width=device-width, initial-scale=1',

];
