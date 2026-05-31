<?php

use Illuminate\Support\Facades\Route;

use function Illuminate\Filesystem\join_paths;

Route::get('/app.webmanifest', fn () => response(json_encode([
    'name' => config('app.name', ''),
    'short_name' => config('app.name', ''),
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
]), 200, ['Content-Type' => 'application/manifest+json']))->name('manifest');

Route::middleware('pwa:entrypoint,manifest')->group(function () {
    Route::middleware('pwa.shell:shells.user')->group(function () {
        Route::view('/account', 'pages.account');
        Route::view('/alerts', 'pages.alerts');
        Route::view('/bookmarks', 'pages.bookmarks');
        Route::view('/posts', 'pages.posts');
        Route::view('/posts/new', 'pages.new-post');
        Route::view('/posts/{post}', 'pages.post')->name('post');
    });
    Route::middleware('pwa.shell:shells.blank')->group(function () {
        Route::view('/', 'pages.home');
        Route::view('/session/login', 'pages.login');
        Route::view('/session/logout', 'pages.logout');
    });
});

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
