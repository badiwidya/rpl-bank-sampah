<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;

uses(RefreshDatabase::class);

test('Bakal nampilin view login admin kalo diakses lewat rute admin.login.show (/admin/login)', function () {
    $this->get(route('admin.login.show'))
        ->assertViewIs('auth.admin-login');
});

test('Bakal nampilin view login nasabah kalo diakses lewat rute nasabah.login.show (/login)', function () {
    $this->get(route('nasabah.login.show'))
        ->assertViewIs('auth.nasabah-login');
});

test('Nasabah akan diarahkan ke halaman login nasabah ketika mencoba masuk di halaman login admin', function () {
    $user = User::factory()->create([
        'no_telepon' => '0812345678',
        'password' => Hash::make('password123')
    ]);

    $this->assertEquals($user->role, 'nasabah');

    $response = $this->post(route('admin.login.submit'), [
        'login' => '0812345678',
        'password' => 'password123'
    ]);
        
    $response->assertRedirect(route('nasabah.login.show'))
        ->assertSessionHasErrors('wrong_route');
});

test('Admin akan diarahkan ke halaman login admin ketika mencoba masuk di halaman login nasabah', function () {
    $user = User::factory()->create([
        'no_telepon' => '0812345678',
        'password' => Hash::make('password123'),
        'role' => 'admin',
    ]);

    $this->assertEquals($user->role, 'admin');

    $response = $this->post(route('nasabah.login.submit'), [
        'login' => '0812345678',
        'password' => 'password123'
    ]);
        
    $response->assertRedirect(route('admin.login.show'))
        ->assertSessionHasErrors('wrong_route');
});

test('User akan masuk ketika menggunakan telepon dan kredensial benar', function () {
    $user = User::factory()->create([
        'no_telepon' => '0812345678',
        'password' => Hash::make('password123')
    ]);

    $response = $this->post(route('nasabah.login.submit'), [
        'login' => '0812345678',
        'password' => 'password123'
    ]);
        
    $response->assertSessionHasNoErrors()
        ->assertRedirect(route('nasabah.dashboard.index'));

    $this->assertAuthenticatedAs($user);

});

test('User akan masuk ketika menggunakan email dan kredensial benar', function () {
    $user = User::factory()->create([
        'email' => 'makise@amadeus.com',
        'password' => Hash::make('password123')
    ]);

    $response = $this->post(route('nasabah.login.submit'), [
        'login' => 'makise@amadeus.com',
        'password' => 'password123'
    ]);
        
    $response->assertSessionHasNoErrors()
        ->assertRedirect(route('nasabah.dashboard.index'));

    $this->assertAuthenticatedAs($user);

});

test('Admin akan masuk ke dashboard admin ketika semua kredensial benar', function () {
    $user = User::factory()->create([
        'email' => 'makise@amadeus.com',
        'password' => Hash::make('password123'),
        'role' => 'admin',
    ]);

    $response = $this->post(route('admin.login.submit'), [
        'login' => 'makise@amadeus.com',
        'password' => 'password123'
    ]);
        
    $response->assertSessionHasNoErrors()
        ->assertRedirect(route('admin.dashboard.index'));

    $this->assertAuthenticatedAs($user);

});

test('User tidak akan masuk ketika kredensial salah', function () {
    $user = User::factory()->create([
        'email' => 'makise@amadeus.com',
        'password' => Hash::make('password123')
    ]);

    $this->post(route('nasabah.login.submit'), [
        'login' => 'makise@amadeus.com',
        'password' => 'password12'
    ])
        ->assertSessionHasErrors('login', 'Kredensial tidak valid, mohon periksa lagi data Anda.');

    $this->assertGuest();

});


test('User akan masuk dengan sesi lama ketika \'Remember Me\' dicentang', function () {
    $user = User::factory()->create(['password' => Hash::make('password123')]);

    $this->post(route('nasabah.login.submit'), [
        'login' => $user->email,
        'password' => 'password123',
        'remember' => 'on'
    ]);

    $this->assertNotNull($user->remember_token);
    
});

test('User bakal keluar kalo logout', function () {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->post(route('auth.logout'))
        ->assertRedirect('/');

    $this->assertGuest();

});

test('Sesi user akan tidak valid kalau logout', function () {
    $user = User::factory()->create();

    $this->actingAs($user);

    $oldSessionId = $this->app['session']->getId();

    $response = $this->post(route('auth.logout'));

    $this->assertNotEquals($oldSessionId, $this->app['session']->getId());

    $response->assertSessionHas('_token');

});