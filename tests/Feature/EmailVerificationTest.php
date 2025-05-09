<?php

use App\Models\User;
use App\Notifications\UserVerification;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;

uses(RefreshDatabase::class);

test('User akan mendapatkan email setelah mendaftar', function () {
    Notification::fake();

    $userInput = [
        'nama_depan' => 'Makise',
        'nama_belakang' => 'Kurisu',
        'email' => 'makise@amadeus.com',
        'no_telepon' => '0812345567',
        'password' => 'kurisu<3',
        'password_confirmation' => 'kurisu<3',
    ];

    $response = $this->post(route('nasabah.register.submit', $userInput));

    $user = User::where('email', $userInput['email'])->first();

    Notification::assertSentTo($user, UserVerification::class);

    $response->assertRedirect(route('mail.verification.notice'));
});

test('User akan mendapatkan email baru setelah menekan tombol resend', function () {
    Notification::fake();

    $user = User::factory()->create([
        'email_verified_at' => null,
    ]);

    $this->actingAs($user)
        ->post(route('mail.verification.resend'));

    Notification::assertSentTo($user, UserVerification::class);
});

test('Resend hanya bisa dilakukan sekali dalam 60 detik', function () {
    $user = User::factory()->create([
        'email_verified_at' => null,
    ]);

    $response = $this->actingAs($user);

    $response->post(route('mail.verification.resend'));

    $response->post(route('mail.verification.resend'))
        ->assertSessionHasErrors(['error']);
});

test('Email user akan terverifikasi ketika mengunjungi link verifikasi email', function () {
    $user = User::factory()->create([
        'email_verified_at' => null,
    ]);

    $this->assertNull($user->email_verified_at);

    $url = $user->generateVerificationUrl();

    $response = $this->actingAs($user);

    $response->get($url);

    $user->fresh();

    $this->assertNotNull($user->email_verified_at);
});

// URL alteration case
test('User tidak akan terverifikasi kalau signature invalid', function () {
    $user = User::factory()->create([
        'email_verified_at' => null,
    ]);

    $this->assertNull($user->email_verified_at);

    $url = $user->generateVerificationUrl() . '123';

    $response = $this->actingAs($user);

    $response->get($url)
        ->assertStatus(419);

    $this->assertNull($user->email_verified_at);
});

test('User tidak akan terverifikasi kalau email berbeda dengan yang dihash', function () {
    $user = User::factory()->create([
        'email_verified_at' => null,
    ]);

    $this->assertNull($user->email_verified_at);

    $url = $user->generateVerificationUrl();

    $user->email = 'test@example.com';
    $user->save();

    $response = $this->actingAs($user);

    $response->get($url)
        ->assertStatus(403);

    $this->assertNull($user->email_verified_at);
});

test('User tidak akan terverifikasi kalau id berubah di url', function () {
    $user = User::factory()->create([
        'email_verified_at' => null,
    ]);

    $this->assertNull($user->email_verified_at);

    $url = $user->generateVerificationUrl();

    $user->id = 3;
    $user->save();

    $response = $this->actingAs($user);

    $response->get($url)
        ->assertStatus(403);

    $this->assertNull($user->email_verified_at);
});

test('Ketika user mengganti email dan mengunjungi link yang dikirim ke email baru, email user akan berubah menjadi email baru', function () {
    $user = User::factory()->create([
        'email' => 'makise@amadeus.com',
        'email_verified_at' => now()->subMinutes(10),
    ]);

    $newEmail = 'kurisu@amadeus.com';

    $url = $user->generateVerificationUrl($newEmail);

    $response = $this->actingAs($user);

    $response->get($url);

    $user->fresh();

    expect($user->email)->toBe($newEmail);
    expect($user->email_verified_at->format('Y-m-d H:i:s'))->toBe(now()->format('Y-m-d H:i:s'));

});