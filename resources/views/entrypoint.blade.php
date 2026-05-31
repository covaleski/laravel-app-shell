<!DOCTYPE html>
<html lang="@yield('lang', config('app.locale'))" hx-headers="{{ json_encode([
    'X-Csrf-Token' => csrf_token(),
]) }}">
    <head>
        @yield('head.start')
        @section('head.title')
            <title>@yield('title', config('app.name'))</title>
        @show
        @section('head.charset')
            <meta charset="@yield('charset', 'UTF-8')"/>
        @show
        @section('head.viewport')
            <meta name="viewport" content="@yield('viewport', 'width=device-width, initial-scale=1')"/>
        @show
        @stack('meta')
        @stack('links.preload')
        @stack('links')
        @stack('styles')
        @yield('head.end')
    </head>
    <body id="app" hx-boost="true" hx-headers="{{ json_encode([
        'HX-Current-Shell' => '',
        'HX-Shell-Target' => '#shell',
        'HX-Page-Target' => '#page',
    ]) }}">
        @yield('body.start')
        @section('body.placeholder')
            <div id="shell" hx-get="" hx-trigger="load from:window"></div>
        @show
        @yield('body.end')
        @section('htmx')
            <script
                type="text/javascript"
                src="https://cdn.jsdelivr.net/npm/htmx.org@2.0.10/dist/htmx.min.js"
                crossorigin="anonymous"
                defer="true"
            ></script>
        @show
        @stack('scripts')
    </body>
</html>
