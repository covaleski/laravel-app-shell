# Laravel PWA

Routing utilities for Progressive Web Application (PWA) development using
nothing but Laravel and HTMX.

## Installation

Install this package using the Composer package manager:

```sh
composer require covaleski/laravel-pwa
```

## Usage

This package works by creating routes for all `page.blade.php` view files it
finds inside a specified view path, complemented by a mandatory top-level
`entrypoint.blade.php` view file and other optional top and page-level files.

### Commands

#### `make:pwa`

```sh
php artisan make:pwa example-pwa
```

#### `make:page`

```sh
php artisan make:page example-pwa.post
```

### Routing

```php
use Covaleski\LaravelPwa\Support\Facades\Pwa;

Pwa::register('example-pwa.entrypoint', 'example-pwa', '/');
```

### Top-Level Files

#### `entrypoint.blade.php`

```blade
@extends('pwa::entrypoint')

@push('assets')
    {{-- Additional <link> elements here. --}}
@endpush

@push('styles')
    {{-- Additional <style> elements here. --}}
@endpush

@push('scripts')
    {{-- Additional <script> elements here. --}}
@endpush
```

#### `manifest.php`

```php
return (new \Covaleski\LaravelPwa\Support\Manifest())
    ->name('Example Progressive Web Application')
    ->shortName('Example PWA')
    ->icon(asset('media/images/icon.png'), '48x48', 'image/png', 'any')
    ->startUrl('.')
    ->display('standalone')
    ->themeColor('red')
    ->backgroundColor('gray');
```

### Page-Level Files

#### `page.blade.php`

```blade
<header>
    <h1>Hello, World!</h1>
</header>
<main>
    <p>This is an example page.</p>
</main>
```

#### `shell.blade.php`

```blade
<x-pwa::shell>
    <header>
        <h1>Example PWA</h1>
    </header>
    <x-pwa::page>
        {!! $page !!}
    </x-pwa::page>
    <footer>
        <p>This is an example footer.</p>
    </footer>
</x-pwa::shell>
```

#### `data.php`

```php
use App\Models\User;

return [
    'users' => User::all(),
];
```

#### `options.php`

```php
use Covaleski\LaravelPwa\Routing\Options;

return new Options(middleware: ['web']);
```

### Configuration

| Key        | Default    | Description                             |
| ---------- | ---------- | --------------------------------------- |
| `charset`  | UTF-8      | Default entrypoint character enconding. |
| `htmx`     | HTMX's CDN | Default HTMX script source URL.         |
| `viewport` | Responsive | Default viewport `<meta>` tag value.    |
