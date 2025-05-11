<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateProfileRequest;
use App\Services\ProfileService;
use Illuminate\Http\Request;

class AdminProfileController extends Controller
{

    public function __construct(
        protected ProfileService $profileService
    ) {}

    public function edit()
    {
        return view('admin.profile');
    }

    public function update(UpdateProfileRequest $request)
    {

        $user = $request->user();

        $validated = $request->safe()->except(['email']);

        $email = $request->safe()->email;

        if ($request->hasFile('avatar')) {
            $this->profileService->updateAvatar($user, $request->file('avatar'));
        }

        $changedEmail = $this->profileService->updateEmail($user, $email);

        $user->update($validated);

        return back()->with([
            'success' => 'Informasi profil Anda telah diperbarui.',
            'email' => $changedEmail
                ? 'Silakan periksa email baru Anda untuk mengganti email, link verifikasi yang diberikan hanya akan bertahan selama 60 menit.'
                : ''
        ]);

    }
}
