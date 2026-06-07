@extends('app-shell::entrypoint')

@push('links')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/main.css') }}"/>
    <link rel="icon" type="image/png" href="{{ asset('assets/icon-48x48.png') }}"/>
    <link rel="manifest" type="application/manifest+json" href="{{ asset('assets/app.webmanifest') }}"/>
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
