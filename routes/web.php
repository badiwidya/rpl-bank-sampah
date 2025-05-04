<?php

use App\Http\Controllers\Auth\RegisterController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::name('nasabah.')->group(function () {
    Route::get('/register', [RegisterController::class, 'create'])->name('register.show');
    Route::post('/register', [RegisterController::class, 'store'])->name('register.submit');
});

Route::prefix('email')->name('mail.')->group(function () {
    Route::get('/verify')->name('verification.notice');
    Route::get('/verify/{hash}/{id}')->name('verification.verify');
    Route::post('/verify')->name('verification.resend');
});