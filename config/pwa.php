<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default Entrypoint View Element Attributes
    |--------------------------------------------------------------------------
    |
    | This option defines the default attributes for the main elements that
    | compose the application entrypoint view.
    |
    */

    'attributes' => [

        'container' => [
            'hx-boost' => 'true',
            'hx-headers' => '{"HX-Current-Shell": "", "HX-Shell-Target": "#shell", "HX-Page-Target": "#page"}',
            'id' => 'app',
        ],

        'page' => [
            'id' => 'page',
        ],

        'placeholder' => [
            'hx-get' => '',
            'hx-trigger' => 'load from:window',
            'id' => 'shell',
        ],

        'shell' => [
            'id' => 'shell',
        ],

        'script' => [
            'crossorigin' => 'anonymous',
            'hash' => 'sha384-H5SrcfygHmAuTDZphMHqBJLc3FhssKjG7w/CeCpFReSfwBWDTKpkzPP8c+cLsK+V',
            'src' => 'https://cdn.jsdelivr.net/npm/htmx.org@2.0.10/dist/htmx.min.js',
            'type' => 'text/javascript',
            'defer' => 'defer',
        ],

    ],

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
        'route' => 'pwa',
        'uri' => '/app',
        'views' => 'pwa',
    ],

];
