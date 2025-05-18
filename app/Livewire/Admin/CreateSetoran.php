<?php

namespace App\Livewire\Admin;

use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

class CreateSetoran extends Component
{
    #[Layout('components.layouts.dashboard')]
    #[Title('Buat Setoran Baru - Bank Sampah')]
    public function render()
    {
        return view('livewire.admin.create-setoran');
    }
}
