<!DOCTYPE html>
<html lang="@yield('lang', config('app.locale'))" hx-headers="{{ json_encode([
    'X-Csrf-Token' => csrf_token(),
]) }}">
    <head>
        @yield('head.start')
        <title>@yield('title', config('app.name'))</title>
        @section('meta')
            <meta charset="@yield('charset', 'UTF-8')"/>
            <meta name="viewport" content="@yield('viewport', 'width=device-width, initial-scale=1')"/>
            @stack('meta')
        @show
        @section('assets.preload')
            @stack('assets.preload')
        @show
        @section('assets')
            <link rel="manifest" type="application/manifest+json" href="{{ $manifest }}"/>
            @stack('assets')
        @show
        @section('styles')
            @stack('styles')
        @show
        @yield('head.end')
    </head>
    <body id="app" hx-boost="true" hx-headers="{{ json_encode([
        'HX-Current-Shell' => '',
        'HX-Shell-Target' => '#shell',
        'HX-Page-Target' => '#page',
    ]) }}">
        @yield('body.start')
        <div id="shell" hx-get="" hx-trigger="load from:window"></div>
        @yield('body.end')
        @section('scripts')
            <script
                type="text/javascript"
                src="{{ config('pwa.htmx') }}"
                @if(request()->host() !== uri(config('pwa.htmx'))->host())
                    crossorigin="anonymous"
                @endif
                defer="true"
            ></script>
            @stack('scripts')
        @show
    </body>
</html>
