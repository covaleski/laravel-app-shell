# Laravel App Shell Utilities

This package provides middleware, views, and directives to quickly build a full
app-shell architecture implementation using only Laravel and HTMX.

## Installation

Install this package using the Composer package manager:

```sh
composer require covaleski/laravel-app-shell-utils
```

To customize default layouts, run the following command to
publish assets:

```sh
php artisan vendor:publish --tag=laravel-app-shell
```

## Usage

This package uses HTMX and Laravel middleware to provide optimized component
swapping during user navigation. It connects your application's front and
back-end to ensure that:

1. The application serves the entrypoint view when the user first accesses the app;
2. Further navigation works by swapping elements instead of loading documents;
3. Shell elements - such as a topbar - are only swapped when necessary.

### Entrypoint Views

Entrypoint views are served to non-HTMX HTML requests, such as when the user
accesses your website by clicking a link. These views contain structures, styles
and scripts that are used by all furtherly loaded pages.

Usually, you'll create a view that extends `app-shell::entrypoint`, make your
additions - such as including custom assets - and then reference it in your
routing files through the `with-entrypoint` middleware:

```html
<!-- resources/views/my-entrypoint.blade.php -->

@extends('app-shell::entrypoint')

@push('links')
    {{-- Add icons, stylesheets, the manifest, etc. --}}
    <link rel="stylesheet" type="text/css" href="/assets/styles.css"/>
    <link rel="icon" type="image/png" href="/assets/favicon.png"/>
@endpush

@push('styles')
    {{-- Add custom styles that should be available immediatly --}}
    <style>
        body {
            background-color: gray;
        }
    </style>
@endpush

@section('htmx')
    {{-- Replace the default HTMX script --}}
    <script type="text/javascript" src="/assets/htmx.min.js" defer="true">
    </script>
@endsection
```

```php
// routes/web.php

Route::middleware('with-entrypoint:my-entrypoint')->group(function () {
    /* Shell groups and pages go here... */
});
```

### Shell Views

Shell views wrap pages that use the same application layout. They are swapped
when the next page needs a different shell - and kept otherwise.

In your shell views, use the `@shell` directive in the root element and the
`@page` directive in the page container element.

```html
<!-- resources/views/my-entrypoint.blade.php -->

@extends('app-shell::shell')

@section('page.tag', "main")

@section('page.before')
@section

@section('page.after')
@section
```

```php
// routes/web.php

Route::middleware('with-entrypoint:my-entrypoint')->group(function () {
    Route::middleware('with-shell:my-shell-1')->group(function () {
        /* Pages that require my-shell-1 go here... */
    });
    Route::middleware('with-shell:my-shell-2')->group(function () {
        /* Pages that require my-shell-2 go here... */
    });
});
```

> Keep in mind that shell views should only contain HTML suitable in the
> `<body>` element, as the entrypoint view is already a complete HTML
> document.

### Routes

Once you have your entrypoint and shells set, you can serve any HTML content you
want under its route groups. Just remember the contents should suit the shell
specified in the `with-shell` middleware:

```html
<!-- resources/views/home.blade.php -->

<header>
    <h1>Home Page</h1>
</header>
<main>
    <p>Welcome to the home page.</p>
</main>
```

```php
// routes/web.php

Route::middleware('with-entrypoint:my-entrypoint')->group(function () {
    Route::middleware('with-shell:my-shell-1')->group(function () {
        Route::view('/', 'home');
    });
});
```

> This repository contains a fully working example inside `/workbench`. To check
> it out, just clone the repo and run `composer install && composer run serve`.
