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

    public $user;

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
            'email' => [
                'required',
                'email',
                Rule::unique('users', 'email')
                    ->ignore(Auth::id())
            ],
            'no_telepon' => [
                'required',
                'regex:/^08[0-9]{8,11}$/',
                Rule::unique('users', 'no_telepon')
                    ->ignore(Auth::id())
            ],
            'image' => 'sometimes|nullable|mimes:jpg,jpeg,png|max:4096',
            'alamat' => 'sometimes|nullable|string',
            'metode_pembayaran_utama' => 'sometimes|nullable|string',
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
        $this->user = Auth::user();
        $this->nama_depan = $this->user->nama_depan;
        $this->nama_belakang = $this->user->nama_belakang;
        $this->email = $this->user->email;
        $this->no_telepon = $this->user->no_telepon;
        $this->mode = $this->user->role;
        $this->alamat = $this->user->profile?->alamat;
        $this->metode_pembayaran_utama = $this->user->profile?->metode_pembayaran_utama;
    }

    public function boot(ProfileService $service)
    {
        $this->service = $service;
    }

    public function update()
    {
        $this->trimInput();
        $validated = $this->validate();

        try {
            $message = 'Informasi profil Anda telah diperbarui.';

            $isChangeEmail = $this->service->updateEmail($this->user, $validated['email']);

            if ($this->image) {
                $this->service->updateAvatar($this->user, $this->image);
                $this->image = null;
            }

            if ($isChangeEmail) {
                $message = $message . ' Silakan periksa email baru Anda untuk mengganti email';
            }

            $this->user->update(Arr::except($validated, ['image', 'email', 'alamat', 'metode_pembayaran_utama']));

            if ($this->mode === 'nasabah')
                $this->user->profile()->update(Arr::only($validated, ['alamat', 'metode_pembayaran_utama']));

            $this->user->fresh();

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
        try {
            $this->service->deleteAvatar($this->user);
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
