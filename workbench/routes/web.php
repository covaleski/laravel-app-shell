<?php

use Illuminate\Support\Facades\Route;

use function Illuminate\Filesystem\join_paths;

Route::get('assets/{asset}', function (string $asset) {
    $base_path = dirname(__DIR__);
    $filename = join_paths($base_path, 'resources', 'assets', $asset);
    if (!file_exists($filename)) {
        return response("{$filename} not found.", 404);
    }
    return response(file_get_contents($filename), 200, [
        'Content-Type' => match (str($asset)->afterLast('.')->toString()) {
            'css' => 'text/css',
            'js' => 'text/javascript',
            'png' => 'image/png',
        },
    ]);
})->where('asset', '([A-Za-z0-9_-]+\.)+(css|js|png)');
