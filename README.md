# Shelter

Quick app-shell architecture implementation for Laravel using Blade and HTMX.

## Installation

Install this package using the Composer package manager:

```sh
composer require covaleski/shelter
```

## Usage

This package works by grouping your user interface routes under the
`with-entrypoint` and the `with-shell` middleware. These middleware ensure that
the user is first served with an entrypoint view and that subsequent HTMX
requests get only the HTML they need.

### Entrypoint

The entrypoint view is served when the user first accesses your application.
It contains you front-end's basic structure and reusable assets. This package
features an entrypoint template - which contains universal metadata and assets
from HTMX - you can extend to add your own assets and persistent components:

```html
@extends('shelter::entrypoint')

@push('links')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/main.css') }}"/>
    <link rel="icon" type="image/png" href="{{ asset('assets/icon-48x48.png') }}"/>
    <link rel="manifest" type="application/manifest+json" href="{{ asset('assets/app.webmanifest') }}"/>
@endpush

@section('body.end')
    <script type="text/javascript" src="{{ asset('assets/main.js') }}"></script>
@endsection
```

Once you has your entrypoint view defined, you can reference it using the
`with-entrypoint` middleware:

```php
use Illuminate\Support\Facades\Route;

Route::middleware('with-entrypoint:my-entrypoint')->group(function () {
    /* HTML routes */
});
```

After the entrypoint loads, it will start fetching actual page contents based
on the browser's current URL. When the user clicks a link, only necessary parts
of the active page are swapped instead of the whole document.

### Shell

Shell views wrap pages that require the same set of persisting UI components,
such as a topbar or a floating button.

When the user clicks a link and the next route requires the same shell as the
previous one, only the inner page contents are actually updated. Otherwise, when
a different shell is needed, the outgoing response contents are wrapped and the
whole shell is replaced, although still preserving outer contents from the
entrypoint view.

This package features two directives to help building shell views, `@shell` and
`@page`, which identify, respectively, the top-level shell element and the page
inner contents container:

```html
<div class="shell" @shell>
    <header>
        <h1>My Website</h1>
    </header>
    <main @page>
        {!! $page !!}
    </main>
</div>
```

Each defined shell view can be assigned to a group of routes using the
`with-shell` directive:

```php
use Illuminate\Support\Facades\Route;

Route::middleware('with-shell:default-shell')->group(function () {
    Route::view('/', /* Home page action */);
    Route::view('/about', /* About page action */);
});
Route::middleware('with-shell:auth-shell')->group(function () {
    Route::view('/signin', /* Login page action */);
    Route::view('/signup', /* Registration page action */);
});
```

In the example above, when the user is at `/about` and clicks a
link leading to `/`, all peripheral UI defined within the `default-shell` view
is preserved. However, when it clicks a login button leading to `/signin`, the
response HTML is wrapped within the `auth-shell` view and the whole front-end
shell element is swapped by the response contents, wiping previously persistent
UI components.
