<?php

return (new \Covaleski\LaravelPwa\Support\Manifest())
    ->name(config('app.name'))
    ->shortName(config('app.name'))
    ->icon(asset('assets/icon.48x48.png'), '48x48', 'image/png', 'any')
    ->icon(asset('assets/icon.512x512.png'), '512x512', 'image/png', 'any')
    ->startUrl('.')
    ->display('standalone')
    ->themeColor('black')
    ->backgroundColor('white');
