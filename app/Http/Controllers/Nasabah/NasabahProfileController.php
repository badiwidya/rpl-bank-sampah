<?php

namespace App\Http\Controllers\Nasabah;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateProfileRequest;
use App\Services\ProfileService;
use Illuminate\Http\Request;

class NasabahProfileController extends Controller
{
    public function __construct(
        protected ProfileService $profileService
    ) {}

    public function edit()
    {
        return view('nasabah.profile');
    }

    public function update(UpdateProfileRequest $request)
    {
        $user = $request->user();

        $validatedUserInformation = $request->safe()->except(['email', 'alamat', 'metode_pembayaran_utama']);

        $validatedProfileInformation = $request->safe()->only(['alamat', 'metode_pembayaran_utama']);

        $email = $request->safe()->email;

        if ($request->hasFile('avatar')) {
            $this->profileService->updateAvatar($user, $request->file('avatar'));
        }

        if($request->safe()->delete_avatar) {
            $this->profileService->deleteAvatar($user);
        }

        $changedEmail = $this->profileService->updateEmail($user, $email);

        $user->update($validatedUserInformation);

        $user->profile()->update($validatedProfileInformation);

        return back()->with([
            'success' => 'Informasi profil Anda telah diperbarui.',
            'email' => $changedEmail
                ? 'Silakan periksa email baru Anda untuk mengganti email, link verifikasi yang diberikan hanya akan bertahan selama 60 menit.'
                : ''
        ]);
    }
}
