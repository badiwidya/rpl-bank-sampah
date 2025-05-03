<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('Mendaftarkan user dan membuat profil serta langsung masuk ketika semua field valid', function () {

    $userInput = [
        'nama' => 'Makise Kurisu',
        'email' => 'makise@amadeus.com',
        'no_telepon' => '0812345567',
        'password' => 'kurisu<3',
        'password_confirmation' => 'kurisu<3',
    ];

    $response = $this->post(route('nasabah.register.show'), $userInput);

    $response->assertSessionHasNoErrors();

    $this->assertDatabaseHas('users', [
        'email' => 'makise@amadeus.com',
    ]);

    $user = User::where('email', 'makise@amadeus.com')->first();

    $this->assertAuthenticatedAs($user);

    $this->assertNotNull($user->profile);

});

test('Password otomatis ter-hash ketika user mendaftar', function () {
    $userInput = [
        'nama' => 'Makise Kurisu',
        'email' => 'makise@amadeus.com',
        'no_telepon' => '0812345567',
        'password' => 'kurisu<3',
        'password_confirmation' => 'kurisu<3',
    ];

    $response = $this->post(route('nasabah.register.show'), $userInput);

    $user = User::where('email', 'makise@amadeus.com')->first();

    $this->assertNotEquals('kurisu<3', $user->password);

});

test('User tidak terdaftar ketika format email tidak valid', function () {
    $userInput = [
        'nama' => 'Makise Kurisu',
        'email' => 'makise2amadeus.com',
        'no_telepon' => '0812345567',
        'password' => 'kurisu<3',
        'password_confirmation' => 'kurisu<3',
    ];

    $response = $this->post(route('nasabah.register.show'), $userInput);

    $response->assertSessionHasErrors(['email']);

});

test('User tidak terdaftar ketika nomor telepon bukan nomor Indonesia yang valid', function () {
    $userInput = [
        'nama' => 'Makise Kurisu',
        'email' => 'makise@amadeus.com',
        'no_telepon' => '9212893172',
        'password' => 'kurisu<3',
        'password_confirmation' => 'kurisu<3',
    ];

    $response = $this->post(route('nasabah.register.show'), $userInput);

    $response->assertSessionHasErrors(['no_telepon']);

});

test('User tidak terdaftar ketika password tidak sama dengan confirm password', function () {
    $userInput = [
        'nama' => 'Makise Kurisu',
        'email' => 'makise@amadeus.com',
        'no_telepon' => '0812345678',
        'password' => 'kurisu<3',
        'password_confirmation' => 'makise<3',
    ];

    $response = $this->post(route('nasabah.register.show'), $userInput);

    $response->assertSessionHasErrors(['password']);

});

test('User tidak terdaftar ketika password kurang dari 8 karakter', function () {
    $userInput = [
        'nama' => 'Makise Kurisu',
        'email' => 'makise@amadeus.com',
        'no_telepon' => '0812345678',
        'password' => 'chris<3',
        'password_confirmation' => 'chris<3',
    ];

    $response = $this->post(route('nasabah.register.show'), $userInput);

    $response->assertSessionHasErrors(['password']);

});

test('User tidak terdaftar ketika password lebih dari 8 karakter tapi tidak ada setidaknya 1 angka', function () {
    $userInput = [
        'nama' => 'Makise Kurisu',
        'email' => 'makise@amadeus.com',
        'no_telepon' => '0812345678',
        'password' => 'kurisutina',
        'password_confirmation' => 'kurisutina',
    ];

    $response = $this->post(route('nasabah.register.show'), $userInput);

    $response->assertSessionHasErrors(['password']);

});

test('User tidak terdaftar ketika password lebih dari 8 karakter tapi tidak ada setidaknya 1 huruf', function () {
    $userInput = [
        'nama' => 'Makise Kurisu',
        'email' => 'makise@amadeus.com',
        'no_telepon' => '0812345678',
        'password' => '100034589',
        'password_confirmation' => '100034589',
    ];

    $response = $this->post(route('nasabah.register.show'), $userInput);

    $response->assertSessionHasErrors(['password']);

});