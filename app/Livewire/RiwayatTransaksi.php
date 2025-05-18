<?php

namespace App\Livewire;

use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

class RiwayatTransaksi extends Component
{
    #[Layout('components.layouts.dashboard')]
    #[Title('Riwayat Transaksi - Bank Sampah')]
    public function render()
    {
        return view('livewire.riwayat-transaksi');
    }
}
