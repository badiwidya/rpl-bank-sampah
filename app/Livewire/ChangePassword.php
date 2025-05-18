<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Validation\Rules\Password;
use Livewire\Attributes\Title;
use Livewire\Component;
use Masmerise\Toaster\Toaster;

class ChangePassword extends Component
{
    public $currentPassword;

    public $password;
    public $password_confirmation;

    public function rules()
    {
        return [
            'currentPassword' => 'required|string',
            'password' => ['required', 'string', 'confirmed', Password::min(8)->letters()->numbers()]
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

            $this->password = null;
            $this->currentPassword = null;
            $this->password_confirmation = null;

            $user->notify(new \App\Notifications\ChangePassword());

            return Redirect::route($user->role.'.dashboard.profile')->success('Ganti password berhasil!');
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
