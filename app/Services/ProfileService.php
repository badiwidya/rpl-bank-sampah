<?php

namespace App\Services;

use App\Models\User;
use App\Notifications\UserVerification;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Storage;

class ProfileService
{
    public function updateAvatar(User $user, UploadedFile $avatar)
    {
        $oldAvatarUrl = $user->avatar_url;

        $avatarUrl = $avatar->store('avatars', 'public');

        $updated = $user->update(['avatar_url' => $avatarUrl]);

        if ($oldAvatarUrl && $updated) {
            Storage::disk('public')->delete($oldAvatarUrl);
        }
    }

    public function updateEmail(User $user, string $email)
    {

        if ($user->email === $email) {
            return false;
        }

        $url = $user->generateVerificationUrl($email);

        Notification::route('mail', $email)->notify(new UserVerification($url, true, $user));

        return true;

    }

    public function deleteAvatar(User $user)
    {
        if ($user->avatar_url != null) {
            Storage::disk('public')->delete($user->getRawOriginal('avatar_url'));
            $user->update([
                'avatar_url' => null,
            ]);
        }
    }
}
