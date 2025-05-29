<?php

use App\Models\User;
use App\Notifications\UserVerification;
use App\Services\ProfileService;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;

uses(TestCase::class, RefreshDatabase::class);

test('Sukses update avatar dan taruh di storage', function () {

    Storage::fake('public');

    $user = User::factory()->create();

    expect($user->getRawOriginal('avatar_url'))->toBe(null);

    $avatar = UploadedFile::fake()->image('avatar.jpg');

    $service = new ProfileService();

    $service->updateAvatar($user, $avatar);

    expect($user->fresh()->getRawOriginal('avatar_url'))->toBeString();
    Storage::disk('public')->assertExists($user->getRawOriginal('avatar_url'));

});

test('Sukses update avatar yang sudah ada dan hapus avatar lama dari storage', function () {
    Storage::fake('public');
    $oldAvatar = UploadedFile::fake()->image('oldAvatar.jpg');

    $oldPath = $oldAvatar->store('avatars', 'public');

    $user = User::factory()->create(['avatar_url' => $oldPath]);

    expect($user->getRawOriginal('avatar_url'))->toBe($oldPath);

    $avatar = UploadedFile::fake()->image('avatar.jpg');

    $service = new ProfileService();

    $service->updateAvatar($user, $avatar);

    expect($user->fresh()->getRawOriginal('avatar_url'))->toBeString();
    Storage::disk('public')->assertExists($user->getRawOriginal('avatar_url'));
    Storage::disk('public')->assertMissing($oldPath);

});

test('Tidak akan mengirimkan email dan akan mengembalikan false kalau email user sama', function () {
    Notification::fake();
    $user = User::factory()->create();

    $service = new ProfileService();

    $newEmail = $user->email;

    $result = $service->updateEmail($user, $newEmail);

    Notification::assertNothingSent();
    expect($result)->toBe(false);

});

test('Email akan terkirim ke email baru dan akan mengembalikan true', function () {
    Notification::fake();

    $user = User::factory()->create();

    $service = new ProfileService();

    $newEmail = 'makise@amadeus.com';

    $result = $service->updateEmail($user, $newEmail);

    Notification::assertSentOnDemand(
        UserVerification::class, 
        function (UserVerification $notification, array $channel, object $notifiable) use ($newEmail) {
            return $notifiable->routes['mail'] === $newEmail;
        }
    );

    expect($result)->toBe(true);
    
});

test('Email user tidak akan berubah sebelum memencet link di email baru mereka', function () {
    Notification::fake();

    $user = User::factory()->create([
        'email' => 'makise@amadeus.com',
        'email_verified_at' => now(),
    ]);

    $service = new ProfileService();

    $newEmail = 'kurisu@amadeus.com';

    $result = $service->updateEmail($user, $newEmail);

    expect($result)->toBe(true);
    expect($user->fresh()->email)->not->toBe($newEmail);
    
});