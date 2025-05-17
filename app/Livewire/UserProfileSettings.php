<?php

namespace App\Livewire;

use App\Services\ProfileService;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithFileUploads;
use Masmerise\Toaster\Toaster;

class UserProfileSettings extends Component
{
    use WithFileUploads;
    protected ProfileService $service;

    public $nama_depan;

    public $nama_belakang;

    public $email;

    public $no_telepon;

    public $image;

    public $isDelete = false;

    protected function rules()
    {
        return [
            'nama_depan' => 'required|string|min:3|max:255',
            'nama_belakang' => 'required|string|min:3|max:255',
            'email' => ['required', 'email', Rule::unique('users', 'email')->ignore(Auth::id())],
            'no_telepon' => ['required', 'regex:/^08[0-9]{8,11}$/', Rule::unique('users', 'no_telepon')->ignore(Auth::id())],
            'image' => 'sometimes|nullable|mimes:jpg,jpeg,png|max:4096',
        ];
    }

    public function mount()
    {
        $user = Auth::user();
        $this->nama_depan = $user->nama_depan;
        $this->nama_belakang = $user->nama_belakang;
        $this->email = $user->email;
        $this->no_telepon = $user->no_telepon;
    }

    public function boot(ProfileService $service)
    {
        $this->service = $service;
    }

    public function update()
    {
        $validated = $this->validate();
        $user = Auth::user();

        try {

            $isChangeEmail = $this->service->updateEmail($user, $validated['email']);

            if ($this->image) {
                $this->service->updateAvatar($user, $this->image);
                $this->image = null;
            }

            if ($isChangeEmail) {
                Toaster::success('Silakan periksa email baru Anda untuk mengganti email.');
            }

            $user->update(Arr::except($validated, ['image']));

            Toaster::success('Informasi profil Anda telah diperbarui.');
        } catch (\Exception $e) {
            Toaster::error('Gagal memperbarui informasi profil Anda.');
        }
    }

    public function deleteAvatar()
    {
        $user = Auth::user();

        try {
            $this->service->deleteAvatar($user);
            $this->isDelete = false;
            $this->image = null;
            Toaster::success('Avatar Anda telah dihapus.');
        } catch (\Exception $e) {
            Toaster::error('Gagal menghapus avatar Anda.');
        }
    }

    #[Title('Pengaturan Profil - Bank Sampah')]
    public function render()
    {
        return view('livewire.user-profile-settings');
    }
}
