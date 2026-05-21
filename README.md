# Laravel PWA

Middleware, layouts and components for developing a Progressive Web Application
(PWA) with a full app-shell architecture implementation using nothing but
Laravel and HTMX.

## Installation

Install this package using the Composer package manager:

```sh
composer require covaleski/laravel-pwa
```

## Usage

This package works by automatically handling content negotiation through the
`pwa` and the `pwa.shell` middlewares:

```php
use Illuminate\Support\Facades\Route;

Route::get('app.manifest', function () {
    return response()->json(['name' => 'My App']);
})->name('manifest');

Route::middleware('pwa:entrypoint,manifest')->group(function () {
    Route::middleware('pwa.shell:visitor')->group(function () {
        Route::view('/home', 'home');
        Route::view('/login', 'login');
    });
    Route::middleware('pwa.shell:member')->group(function () {
        Route::view('/dashboard', 'dashboard');
        Route::view('/profile', 'profile');
    });
});
```

The example above features 2 important steps regarding the use of this package:
grouping page routes from the same PWA within the `pwa` middleware and grouping
page routes that require the same shell layout within the `pwa.shell`
middleware.

> @todo Document page views

> @todo Document shell views

> @todo Document entrypoint views

> @todo Give further details on the `pwa` middleware behavior

> @todo Give further details on the `pwa.shell` middleware behavior
