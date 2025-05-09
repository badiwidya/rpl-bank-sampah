<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('Data profil nasabah akan terupdate untuk field selain email dan avatar', function () {
    $user = User::factory()->create(['role' => 'nasabah']);

    $user->profile()->create();

    $this->actingAs($user);

    $response = $this->post(route('nasabah.dashboard.profile.submit'), [
        'nama_depan' => 'Kurisu',
        'nama_belakang' => 'Makise',
        'email' => $user->email,
        'no_telepon' => '0888234798',
        'metode_pembayaran_utama' => 'Gopay',
        'alamat' => 'Japan, 〒101-0021 Tokyo, Chiyoda City, Sotokanda, 3 Chome-6-11 小桧山ビル 1F',
        'avatar' => $user->avatar_url
    ]);

    $user->fresh();

    expect($user->nama_depan)->toBe('Kurisu');
    expect($user->nama_belakang)->toBe('Makise');
    expect($user->no_telepon)->toBe('0888234798');
    expect($user->profile->metode_pembayaran_utama)->toBe('Gopay');
    expect($user->profile->alamat)->toBe('Japan, 〒101-0021 Tokyo, Chiyoda City, Sotokanda, 3 Chome-6-11 小桧山ビル 1F');

    $response->assertSessionHasNoErrors()
        ->assertSessionHasAll([
            'success' => 'Informasi profil Anda telah diperbarui.',
            'email' => ''
        ]);

});

test('Update profil akan gagal kalau nomor telepon sudah ada di database', function () {
    User::factory()->create(['no_telepon' => '0888234798']);
    $user = User::factory()->create(['role' => 'nasabah']);

    $user->profile()->create();

    $this->actingAs($user);

    $response = $this->post(route('nasabah.dashboard.profile.submit'), [
        'nama_depan' => 'Kurisu',
        'nama_belakang' => 'Makise',
        'email' => $user->email,
        'no_telepon' => '0888234798',
        'avatar' => $user->avatar_url
    ]);

    $user->fresh();

    // Data tidak terupdate
    expect($user->nama_depan)->toBe($user->nama_depan);
    expect($user->nama_belakang)->toBe($user->nama_belakang);

    // Response invalid
    $response->assertSessionHasErrors()
        ->assertInvalid(['no_telepon']);

});

test('Update profil akan gagal kalau email sudah ada di database', function () {
    User::factory()->create(['email' => 'ookabe@amadeus.com']);
    $user = User::factory()->create(['role' => 'nasabah']);

    $user->profile()->create();

    $this->actingAs($user);

    $response = $this->post(route('nasabah.dashboard.profile.submit'), [
        'nama_depan' => 'Kurisu',
        'nama_belakang' => 'Makise',
        'email' => 'ookabe@amadeus.com',
        'no_telepon' => '0888234798',
        'avatar' => $user->avatar_url
    ]);

    $user->fresh();

    // Data tidak terupdate
    expect($user->nama_depan)->toBe($user->nama_depan);
    expect($user->nama_belakang)->toBe($user->nama_belakang);

    // Response invalid
    $response->assertSessionHasErrors()
        ->assertInvalid(['email']);

});

test('Akan menghasilkan response dengan session email ketika mengganti email', function () {
    $user = User::factory()->create(['role' => 'nasabah']);

    $user->profile()->create();

    $this->actingAs($user);

    $response = $this->post(route('nasabah.dashboard.profile.submit'), [
        'nama_depan' => 'Kurisu',
        'nama_belakang' => 'Makise',
        'email' => 'kurisu@amadeus.com',
        'no_telepon' => '0888234798',
        'avatar' => $user->avatar_url
    ]);

    $user->fresh();

    expect($user->nama_depan)->toBe('Kurisu');
    expect($user->nama_belakang)->toBe('Makise');
    expect($user->no_telepon)->toBe('0888234798');

    $response->assertSessionHasNoErrors()
        ->assertSessionHasAll([
            'success' => 'Informasi profil Anda telah diperbarui.',
            'email' => 'Silakan periksa email baru Anda untuk mengganti email, link verifikasi yang diberikan hanya akan bertahan selama 60 menit.'
        ]);

});