<?php

// Landing pages.
Route::name('landing')->get('/', 'LandingController@index');
Route::name('landing.terms')->get('terms', 'LandingController@terms');

// Authorization pages.
Auth::routes();

// Dashboard pages.
Route::name('dashboard')->get('/home', 'DashboardController@index');

// User pages.
Route::resource('user', 'UserController', [
    'only' => [ 'show', 'edit', 'update', 'destroy' ]
]);