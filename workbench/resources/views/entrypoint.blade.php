@extends('pwa::entrypoint')

@push('links.preload')
    @bootstrap_css_preload
    @bootstrap_icons_preload
@endpush

@push('links')
    @bootstrap_css
    @bootstrap_icons
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/main.css') }}"/>
    <link rel="icon" type="image/png" href="{{ asset('assets/icon.48x48.png') }}"/>
@endpush

@push('styles')
    <style>
        .overlay {
            background: white;
            position: fixed;
            width: 100vw;
            height: 100vh;
            z-index: 2;
            transition: opacity 500ms, width 0ms 500ms, height 0ms 500ms;
        }

        .shell {
            width: 100vw;
            height: 100vh;
        }

        .shell + .overlay {
            opacity: 0;
            width: 0;
            height: 0;
        }
    </style>
@endpush

@section('body.end')
    <div id="overlay" class="overlay"></div>
@endsection

@push('scripts')
    @bootstrap_js
    <script type="text/javascript" src="{{ asset('assets/bootstrap.extend.js') }}" defer="defer">
    </script>
    <script type="text/javascript" src="{{ asset('assets/htmx.extend.js') }}" defer="defer">
    </script>
@endpush
