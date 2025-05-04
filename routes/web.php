<?php

use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\UserEmailVerificationController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::name('nasabah.')->group(function () {
    Route::get('/register', [RegisterController::class, 'create'])->name('register.show');
    Route::post('/register', [RegisterController::class, 'store'])->name('register.submit');
});

Route::prefix('email')->name('mail.')->group(function () {
    Route::get('/verify', [UserEmailVerificationController::class, 'notice'])->name('verification.notice');
    Route::get('/verify/{hash}/{id}', [UserEmailVerificationController::class, 'verify'])->name('verification.verify');
    Route::post('/verify', [UserEmailVerificationController::class, 'resend'])->name('verification.resend');
});