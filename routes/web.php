<?php

use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\SessionController;
use App\Http\Controllers\Auth\UserEmailVerificationController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Rute nasabah
// prefix nama rute "nasabah."
Route::name('nasabah.')->group(function () {

    // Rute autentikasi nasabah
    Route::middleware('guest')->group(function () {

        Route::get('/register', [RegisterController::class, 'create'])->name('register.show');
        Route::post('/register', [RegisterController::class, 'store'])->name('register.submit');

        Route::get('/login', [SessionController::class, 'create'])->name('login.show');
        Route::post('/login', [SessionController::class, 'store'])->name('login.submit');

    });

    // Segala rute yang ada di dashboard
    // Prefix rute '/dashboard' dan prefix nama 'dashboard.'
    Route::prefix('dashboard')->middleware(['auth', 'verified', 'role:nasabah'])->name('dashboard.')->group(function () {
        
        Route::get('/', function () {})->name('index');
   
    });

});

Route::prefix('admin')->name('admin.')->group(function () {

    // Rute autentikasi admin
    Route::middleware('guest')->group(function () {

        Route::get('/login', [SessionController::class, 'create'])->name('login.show');
        Route::post('/login', [SessionController::class, 'store'])->name('login.submit');

    });

    // Semua rute di dashboard admin
    // Prefix url '/dashboard' (kalo digabungin sama yang atas jadi '/admin/dashboard') dan prefix nama 'dashboard.'
    Route::prefix('dashboard')->middleware(['auth', 'verified', 'role:admin'])->name('dashboard.')->group(function () {
        
        Route::get('/', function () {})->name('index');
   
    });

});

// Rute buat verifikasi email 
// Prefix url '/email' dan prefix nama 'mail.'
Route::prefix('email')->name('mail.')->middleware(['auth', 'unverified'])->group(function () {

    Route::get('/verify', [UserEmailVerificationController::class, 'notice'])->name('verification.notice');
    Route::get('/verify/{hash}/{id}', [UserEmailVerificationController::class, 'verify'])->name('verification.verify');
    Route::post('/verify', [UserEmailVerificationController::class, 'resend'])->name('verification.resend');

});

Route::post('/logout', [SessionController::class, 'destroy'])->middleware(['auth'])->name('auth.logout');