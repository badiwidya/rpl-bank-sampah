<?php

namespace App\Livewire\Admin;

use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

class Dashboard extends Component
{
    #[Layout('components.layouts.dashboard')]
    #[Title('Dashboard - Bank Sampah')]
    public function render()
    {
        return view('livewire.admin.dashboard');
    }
}
