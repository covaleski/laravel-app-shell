<?php

return [
    'short_name' => config('app.name'),
    'name' => config('app.name'),
    'icons' => [
        [
            'src' => asset('assets/icon.48x48.png'),
            'sizes' => '48x48',
            'type' => 'image/png',
            'purpose' => 'any',
        ],
        [
            'src' => asset('assets/icon.512x512.png'),
            'sizes' => '512x512',
            'type' => 'image/png',
            'purpose' => 'any',
        ],
    ],
    'start_url' => '.',
    'display' => 'standalone',
    'theme_color' => 'black',
    'background_color' => 'white',
];
