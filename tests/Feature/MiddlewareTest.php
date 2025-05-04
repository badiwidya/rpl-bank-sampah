<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('Admin akan terlempar ke dashboard admin saat mencoba mengakses protected guest route', function () {
    $user = User::factory()->create([
        'role' => 'admin',
    ]);

    $this->assertEquals($user->role, 'admin');

    $this->actingAs($user)
        ->get('/register')
        ->assertRedirect(route('admin.dashboard.index'));
});

test('Nasabah akan terlempar ke dashboard basabah saat mencoba mengakses protected guest route', function () {
    $user = User::factory()->create();

    $this->assertEquals($user->role, 'nasabah');

    $this->actingAs($user)
        ->get('/register')
        ->assertRedirect(route('nasabah.dashboard.index'));
});

test('Admin akan menerima status 403 ketika mencoba mengakses protected nasabah route', function () {
    $user = User::factory()->create([
        'role' => 'admin',
    ]);

    $this->assertEquals($user->role, 'admin');

    $this->actingAs($user)
        ->get('/dashboard')
        ->assertStatus(403);
});

test('Nasabah akan menerima status 403 ketika mencoba mengakses protected admin route', function () {
    $user = User::factory()->create();

    $this->assertEquals($user->role, 'nasabah');

    $this->actingAs($user)
        ->get('/admin/dashboard')
        ->assertStatus(403);
});

test('User tidak akan bisa mengakses rute email notice kalau sudah terverifikasi', function () {
    $user = User::factory()->create([
        'email_verified_at' => now(),
    ]);

    $this->assertNotNull($user->email_verified_at);
    $this->actingAs($user)
        ->get(route('mail.verification.notice'))
        ->assertRedirect('/dashboard');
});

test('User akan dialihkan ke email notice ketika mencoba mengakses dashboard dan belum verifikasi email', function () {
    $user = User::factory()->create([
        'email_verified_at' => null,
    ]);

    $this->assertNull($user->email_verified_at);
    $this->actingAs($user)
        ->get(route('nasabah.dashboard.index'))
        ->assertRedirect(route('mail.verification.notice'));
});