<?php

namespace App\Livewire\Nasabah;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class TarikSaldo extends Component
{
    public $user;

    public function mount()
    {
        $this->user = Auth::user();
    }

    public function render()
    {
        return view('livewire.nasabah.tarik-saldo');
    }
}
