<?php

namespace App\Livewire\Admin;

use App\Models\User;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

class CreateSetoran extends Component
{
    public $searchuser = '';
    public $selectedUser;
    public $isUserSelected = false;

    public function selectUser($phone)
    {
        $this->searchuser = $phone;

        $this->selectedUser = User::where('no_telepon', $this->searchuser)->first();
        $this->isUserSelected = true;
    }

    public function filteredUsers()
    {
        if (strlen($this->searchuser) < 2) {
            return collect();
        }

        $keywords = explode(' ', $this->searchuser);

        return User::where('role', 'nasabah')
            ->where(function ($query) use ($keywords) {
                foreach ($keywords as $keyword) {
                    $query->where(function ($q) use ($keyword) {
                        $q->where('no_telepon', 'like', '%' . $keyword . '%')
                            ->orWhere('nama_depan', 'like', '%' . $keyword . '%')
                            ->orWhere('nama_belakang', 'like', '%' . $keyword . '%');
                    });
                }
            })
            ->orderBy('nama_depan')
            ->limit(10)
            ->get();
    }

    #[Layout('components.layouts.dashboard')]
    #[Title('Buat Setoran Baru - Bank Sampah')]
    public function render()
    {
        return view('livewire.admin.create-setoran');
    }
}
