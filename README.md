# Laravel App Shell

Middleware, layouts and components for developing a full app-shell architecture
implementation using nothing but Laravel and HTMX.

## Installation

Install this package using the Composer package manager:

```sh
composer require covaleski/laravel-app-shell
```

## Usage

This package works by automatically handling content negotiation through the
`with-entrypoint` and the `with-shell` middlewares:

```php
use Illuminate\Support\Facades\Route;

Route::middleware('with-entrypoint:entrypoint')->group(function () {
    Route::middleware('with-shell:visitor')->group(function () {
        Route::view('/home', 'home');
        Route::view('/login', 'login');
    });
    Route::middleware('with-shell:member')->group(function () {
        Route::view('/dashboard', 'dashboard');
        Route::view('/profile', 'profile');
    });
});
```

The example above features 2 important steps regarding the use of this package:
grouping page routes from the same app within the `with-entrypoint` middleware
and grouping page routes that require the same shell layout within the
`with-shell` middleware.

> @todo Document page views

> @todo Document shell views

> @todo Document entrypoint views

> @todo Give further details on the `with-entrypoint` middleware behavior

> @todo Give further details on the `with-shell` middleware behavior
