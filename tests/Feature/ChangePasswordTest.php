<?php

use App\Models\User;
use App\Notifications\ChangePassword;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;

uses(RefreshDatabase::class);

test('User berhasil mengganti password dan mendapat email notifikasi ketika semua field benar', function () {
    Notification::fake();

    $user = User::factory()->create(['password' => 'passwordlama123']);

    $this->actingAs($user);

    $response = $this->post(route('nasabah.dashboard.password.update'), [
        'old_password' => 'passwordlama123',
        'password' => 'newpass123',
        'password_confirmation' => 'newpass123',
    ]);

    $response->assertSessionHasNoErrors();

    $user->fresh();

    expect(Hash::check('newpass123', $user->password))->toBe(true);

    $response->assertRedirect(route('nasabah.dashboard.profile'));

    Notification::assertSentTo([$user], ChangePassword::class);
});

test('Password user tidak akan terganti bila password lama salah', function () {
    Notification::fake();

    $user = User::factory()->create();

    $this->actingAs($user);

    $response = $this->post(route('nasabah.dashboard.password.update'), [
        'old_password' => 'passwordlama123',
        'password' => 'newpass123',
        'password_confirmation' => 'newpass123',
    ]);

    $response->assertSessionHasErrors(['old_password']);

    $user->fresh();

    expect(Hash::check('newpass123', $user->password))->toBe(false);

    Notification::assertNothingSentTo([$user], ChangePassword::class);
});

test('Password user tidak akan terganti bila password tidak terkonfirmasi dengan benar', function () {
    Notification::fake();

    $user = User::factory()->create();

    $this->actingAs($user);

    $response = $this->post(route('nasabah.dashboard.password.update'), [
        'old_password' => $user->password,
        'password' => 'newpass123',
        'password_confirmation' => 'newpass128',
    ]);

    $response->assertSessionHasErrors(['password']);

    $user->fresh();

    expect(Hash::check('newpass123', $user->password))->toBe(false);

    Notification::assertNothingSentTo([$user], ChangePassword::class);
});

test('Kalau user mengirim lebih dari 5 permintaan permenit dengan password lama salah, akan rate limit', function () {
    Notification::fake();

    $user = User::factory()->create();

    $this->actingAs($user);

    for ($i = 0; $i < 6; $i++) {
        $this->post(route('nasabah.dashboard.password.update'), [
            'old_password' => 'passlamasalah123',
            'password' => 'newpass123',
            'password_confirmation' => 'newpass123',
        ]);
    }

    $response = $this->post(route('nasabah.dashboard.password.update'), [
        'old_password' => 'passlamasalah123',
        'password' => 'newpass123',
        'password_confirmation' => 'newpass123',
    ]);

    $response->assertSessionHasErrors(['rate_limit']);

    $user->fresh();

    expect(Hash::check('newpass123', $user->password))->toBe(false);

    Notification::assertNothingSentTo([$user], ChangePassword::class);
});