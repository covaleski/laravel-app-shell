<?php

use Illuminate\Support\Facades\Route;

Route::middleware('with-entrypoint:entrypoint')->group(function () {
    Route::middleware('with-shell:shells.user')->group(function () {
        Route::view('/account', 'pages.account');
        Route::view('/alerts', 'pages.alerts');
        Route::view('/bookmarks', 'pages.bookmarks');
        Route::view('/posts', 'pages.posts');
        Route::view('/posts/new', 'pages.new-post');
        Route::view('/posts/{post}', 'pages.post')->name('post');
    });
    Route::middleware('with-shell:shells.blank')->group(function () {
        Route::view('/', 'pages.home');
        Route::view('/session/login', 'pages.login');
        Route::view('/session/logout', 'pages.logout');
    });
});
