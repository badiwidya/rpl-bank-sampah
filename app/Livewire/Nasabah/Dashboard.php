<?php

namespace App\Livewire\Nasabah;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

class Dashboard extends Component
{

    public User $user;

    public function mount()
    {
        $this->user = Auth::user();
    }

    #[Layout('components.layouts.dashboard')]
    #[Title('Dashboard - Bank Sampah')]
    public function render()
    {
        return view('livewire.nasabah.dashboard');
    }
}
