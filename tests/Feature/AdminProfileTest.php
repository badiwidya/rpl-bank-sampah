<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('Data profil admin akan terupdate untuk field selain email dan avatar', function () {
    $admin = User::factory()->create(['role' => 'admin']);

    $this->actingAs($admin);

    $response = $this->post(route('admin.dashboard.profile.submit'), [
        'nama_depan' => 'Kurisu',
        'nama_belakang' => 'Makise',
        'email' => $admin->email,
        'no_telepon' => '0888234798',
        'avatar' => $admin->avatar_url
    ]);

    $admin->fresh();

    expect($admin->nama_depan)->toBe('Kurisu');
    expect($admin->nama_belakang)->toBe('Makise');
    expect($admin->no_telepon)->toBe('0888234798');

    $response->assertSessionHasNoErrors()
        ->assertSessionHas('success', 'Informasi profil Anda telah diperbarui.');

});

test('Update profil akan gagal kalau nomor telepon sudah ada di database', function () {
    User::factory()->create(['no_telepon' => '0888234798']);
    $admin = User::factory()->create(['role' => 'admin']);

    $this->actingAs($admin);

    $response = $this->post(route('admin.dashboard.profile.submit'), [
        'nama_depan' => 'Kurisu',
        'nama_belakang' => 'Makise',
        'email' => $admin->email,
        'no_telepon' => '0888234798',
        'avatar' => $admin->avatar_url
    ]);

    $admin->fresh();

    // Data tidak terupdate
    expect($admin->nama_depan)->toBe($admin->nama_depan);
    expect($admin->nama_belakang)->toBe($admin->nama_belakang);

    // Response invalid
    $response->assertSessionHasErrors()
        ->assertInvalid(['no_telepon']);

});

test('Update profil akan gagal kalau email sudah ada di database', function () {
    User::factory()->create(['email' => 'ookabe@amadeus.com']);
    $admin = User::factory()->create(['role' => 'admin']);

    $this->actingAs($admin);

    $response = $this->post(route('admin.dashboard.profile.submit'), [
        'nama_depan' => 'Kurisu',
        'nama_belakang' => 'Makise',
        'email' => 'ookabe@amadeus.com',
        'no_telepon' => '0888234798',
        'avatar' => $admin->avatar_url
    ]);

    $admin->fresh();

    // Data tidak terupdate
    expect($admin->nama_depan)->toBe($admin->nama_depan);
    expect($admin->nama_belakang)->toBe($admin->nama_belakang);

    // Response invalid
    $response->assertSessionHasErrors()
        ->assertInvalid(['email']);

});