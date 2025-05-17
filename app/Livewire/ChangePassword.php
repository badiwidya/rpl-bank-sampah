<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Redirect;
use Livewire\Attributes\Title;
use Livewire\Component;
use Masmerise\Toaster\Toaster;

class ChangePassword extends Component
{
    public $currentPassword;

    public $password;

    public function rules()
    {
        return [
            'currentPassword' => 'required|string',
            'password' => ['required', 'string', 'confirmerd', Password::min(8)->letters()->numbers()]
        ];
    }

    public function update()
    {
        $validated = $this->validate();
        $user = Auth::user();
        try {

            if (!Hash::check($validated['currentPassword'], $user->password)) {
                Toaster::error('Password lama Anda salah.');
                return;
            }

            $user->update([
                'password' => Hash::make($validated['password'])
            ]);

            return Redirect::route($user->role.'.dashboard.profile')
                ->info('Password berhasil diganti!');

        } catch (\Exception $e) {
            Toaster::error('Terjadi kesalahan saat mengganti password.');
        }
    }

    #[Title('Ganti Password - Bank Sampah')]
    public function render()
    {
        return view('livewire.change-password');
    }
}
