<?php

namespace App\Livewire\Components;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Component;

class Header extends Component
{
    public User $user;

    public function mount()
    {
        $this->user = Auth::user();
    }

    #[On('profile_updated')]
    public function refreshUser()
    {
        $this->user = Auth::user()->fresh();
    }

    public function render()
    {
        return view('livewire.components.header');
    }
}
