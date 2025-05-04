<?php

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;

uses(RefreshDatabase::class);
use App\Models\User;
use App\Notifications\ResetPassword;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;

beforeEach(function () {
    Notification::fake();
});

test('User akan menerima email reset password', function () {
    $user = User::factory()->create();

    $this->post(route('auth.password.email'), [
        'email' => $user->email
    ]);

    Notification::assertSentTo([$user], ResetPassword::class);

});

test('Password user akan tereset dengan sukses', function () {
    $user = User::factory()->create();
    $token = Password::createToken($user);

    $this->post(route('auth.password.update'), [
        'token' => $token,
        'email' => $user->email,
        'password' => 'password123',
        'password_confirmation' => 'password123'
    ])
        ->assertSessionHasNoErrors();

    $this->assertTrue(Auth::attempt([
        'email' => $user->email,
        'password' => 'password123'
    ]));

});

test('Password tidak akan tereset dengan token invalid', function () {
    $user = User::factory()->create();

    $this->post(route('auth.password.update'), [
        'token' => 'token-ngawur',
        'email' => $user->email,
        'password' => 'password123',
        'password_confirmation' => 'password123'
    ])
        ->assertSessionHasErrors('email');
});

test('Email tidak akan terkirim pada email yang tidak terdaftar', function () {

    $this->post(route('auth.password.email'), [
        'email' => 'unregistered.email@example.com'
    ])
        ->assertSessionHasErrors('email');

});