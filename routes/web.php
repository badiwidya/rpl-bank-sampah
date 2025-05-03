<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::name('nasabah.')->group(function () {
    Route::get('/register')->name('register.show');
    Route::post('/register')->name('register.submit');
});