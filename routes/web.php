<?php

use App\Http\Controllers\Admin\AdminProfileController;
use App\Http\Controllers\Auth\ChangePasswordController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\SessionController;
use App\Http\Controllers\Auth\UserEmailVerificationController;
use App\Http\Controllers\Nasabah\NasabahProfileController;
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

        Route::prefix('nasabah')->group(function () {
            Route::get('/login', [SessionController::class, 'create'])->name('login.show');
            Route::post('/login', [SessionController::class, 'store'])->name('login.submit');
        });

    });

    // Segala rute yang ada di dashboard
    // Prefix rute '/dashboard' dan prefix nama 'dashboard.'
    Route::prefix('dashboard')->middleware(['auth', 'verified', 'role:nasabah'])->name('dashboard.')->group(function () {

        Route::get('/', function () {
            return view('nasabah.index');
        })->name('index');
        Route::get('/profile', [NasabahProfileController::class, 'edit'])->name('profile');
        Route::put('/profile', [NasabahProfileController::class, 'update'])->name('profile.submit');
        Route::get('/profile/change-password', [ChangePasswordController::class, 'create'])->name('password');
        Route::post('/profile/change-password', [ChangePasswordController::class, 'update'])->name('password.update');
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

        Route::get('/', function () {
            return view('admin.index');
        })->name('index');
        Route::get('/profile', [AdminProfileController::class, 'edit'])->name('profile');
        Route::put('/profile', [AdminProfileController::class, 'update'])->name('profile.submit');
        Route::get('/profile/change-password', [ChangePasswordController::class, 'create'])->name('password');
        Route::post('/profile/change-password', [ChangePasswordController::class, 'update'])->name('password.update');

        // Sementara
        Route::get('/sampah', function() {
            return view('admin.sampah');
        });
    });

});

// Rute buat verifikasi email
// Prefix url '/email' dan prefix nama 'mail.'
Route::prefix('email')->name('mail.')->middleware(['auth', 'unverified'])->group(function () {

    Route::get('/verify', [UserEmailVerificationController::class, 'notice'])->name('verification.notice');
    Route::get('/verify/{value}/{id}', [UserEmailVerificationController::class, 'verify'])->name('verification.verify')->withoutMiddleware('unverified');
    Route::post('/verify', [UserEmailVerificationController::class, 'resend'])->name('verification.resend');

});

Route::name('auth.')->group(function () {
    Route::get('/login', function () {
        return view('auth.login');
    })->middleware(['guest'])->name('login.choice');
    Route::post('/logout', [SessionController::class, 'destroy'])->middleware(['auth'])->name('logout');

    Route::name('password.')->middleware(['guest'])->group(function () {
        Route::get('/forgot-password', [ForgotPasswordController::class, 'create'])->name('request');
        Route::post('/forgot-password', [ForgotPasswordController::class, 'store'])->name('email');
        Route::get('/reset-password/{token}', [ForgotPasswordController::class, 'edit'])->name('reset');
        Route::post('/reset-password', [ForgotPasswordController::class, 'update'])->name('update');
    });
});

Route::get('/test-nasabah', function () {
    $user = \App\Models\User::where('role', 'nasabah')->first();

    if (! $user) {
        $user = \App\Models\User::factory()->create()->profile()->create();
    }

    \Illuminate\Support\Facades\Auth::login($user);

    return redirect(route('nasabah.dashboard.index'));
});

Route::get('/test-admin', function () {
    $user = \App\Models\User::where('role', 'admin')->first();

    if (! $user) {
        $user = \App\Models\User::factory()->create(['role' => 'admin']);
        $user->profile()->create();
    }

    \Illuminate\Support\Facades\Auth::login($user);

    return redirect(route('admin.dashboard.index'));
});
