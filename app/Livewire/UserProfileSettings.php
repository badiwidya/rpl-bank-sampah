<?php

namespace App\Livewire;

use App\Livewire\Components\Header;
use App\Services\ProfileService;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Layout;
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

    public $mode;

    public $alamat;

    public $metode_pembayaran_utama;

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

    protected function validationAttributes()
    {
        return [
            'image' => 'Foto profil',
        ];
    }

    public function mount()
    {
        $user = Auth::user();
        $this->nama_depan = $user->nama_depan;
        $this->nama_belakang = $user->nama_belakang;
        $this->email = $user->email;
        $this->no_telepon = $user->no_telepon;
        $this->mode = $user->role;
        $this->alamat = $user->profile?->alamat;
        $this->metode_pembayaran_utama = $user->profile?->metode_pembayaran_utama;
    }

    public function boot(ProfileService $service)
    {
        $this->service = $service;
    }

    public function updateAdmin()
    {
        $this->trimInput();
        $validated = $this->validate();
        $user = Auth::user();

        try {

            $message = 'Informasi profil Anda telah diperbarui.';

            $isChangeEmail = $this->service->updateEmail($user, $validated['email']);

            if ($this->image) {
                $this->service->updateAvatar($user, $this->image);
                $this->image = null;
            }

            if ($isChangeEmail) {
                $message = $message . ' Silakan periksa email baru Anda untuk mengganti email';
            }

            $user->update(Arr::except($validated, ['image', 'email']));

            $this->dispatch('profile_updated')->to(Header::class);

            Toaster::success($message);
        } catch (\Exception $e) {
            Toaster::error('Gagal memperbarui informasi profil Anda.');
        }
    }

    public function updateNasabah()
    {
        $this->trimInput();
        $validated = $this->validate();

        $validatedProfile = $this->validate([
            'alamat' => 'nullable|string',
            'metode_pembayaran_utama' => 'nullable|string',
        ]);

        $user = Auth::user();

        try {
            $message = 'Informasi profil Anda telah diperbarui.';

            $isChangeEmail = $this->service->updateEmail($user, $validated['email']);

            if ($this->image) {
                $this->service->updateAvatar($user, $this->image);
                $this->image = null;
            }

            if ($isChangeEmail) {
                $message = $message . ' Silakan periksa email baru Anda untuk mengganti email';
            }

            $user->update(Arr::except($validated, ['image', 'email']));

            $user->profile()->update($validatedProfile);

            $this->dispatch('profile_updated')->to(Header::class);

            Toaster::success($message);
        } catch (\Exception $e) {
            Toaster::error('Gagal memperbarui informasi profil Anda.');
        }
    }

    public function trimInput()
    {
        $this->nama_depan = str(trim($this->nama_depan))->squish()->toString();
        $this->nama_belakang = str(trim($this->nama_belakang))->squish()->toString();
        $this->email = str(trim($this->email))->squish()->toString();
        if ($this->alamat)
            $this->alamat = str(trim($this->alamat))->squish()->toString();
    }

    public function deleteAvatar()
    {
        $user = Auth::user();

        try {
            $this->service->deleteAvatar($user);
            $this->isDelete = false;
            $this->image = null;
            $this->dispatch('profile_updated')->to(Header::class);
            Toaster::success('Avatar Anda telah dihapus.');
        } catch (\Exception $e) {
            Toaster::error('Gagal menghapus avatar Anda.');
        }
    }

    #[Layout('components.layouts.dashboard')]
    #[Title('Pengaturan Profil - Bank Sampah')]
    public function render()
    {
        return view('livewire.user-profile-settings');
    }
}
