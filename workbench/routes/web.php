<?php

use Illuminate\Support\Facades\Route;

Route::middleware('with-entrypoint:entrypoint')->group(function () {
    Route::middleware('with-shell:shells.default')->group(function () {
        Route::view('/', 'pages.home');
        Route::view('/about', 'pages.about');
    });
    Route::middleware('with-shell:shells.blank')->group(function () {
        Route::view('/signin', 'pages.signin');
        Route::view('/signup', 'pages.signup');
    });
});
