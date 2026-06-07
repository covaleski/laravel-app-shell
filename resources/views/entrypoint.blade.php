<!DOCTYPE html>
<html lang="@yield('lang', config('app.locale'))" hx-headers="{{ json_encode(['X-Csrf-Token' => csrf_token()]) }}">
    <head>
        @yield('head.start')
        <title>@yield('title', config('app.name'))</title>
        <meta charset="@yield('charset', 'UTF-8')"/>
        <meta name="viewport" content="@yield('viewport', 'width=device-width, initial-scale=1')"/>
        @stack('meta')
        @stack('links.preload')
        @stack('links')
        @stack('styles')
        @yield('head.end')
    </head>
    <body hx-boost="true">
        @yield('body.start')
        @section('placeholder')
            <div id="shell" hx-get="" hx-trigger="load from:window" hx-headers="{{ json_encode(['X-Current-Shell' => '']) }}">
            </div>
        @show
        @section('htmx')
            <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/htmx.org@2.0.10/dist/htmx.min.js" crossorigin="anonymous" defer="true">
            </script>
        @show
        @stack('scripts')
        @yield('body.end')
    </body>
</html>
