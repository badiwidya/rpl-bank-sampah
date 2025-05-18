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

    public $totalPendapatan;

    public $totalBeratSampah;

    public $totalSetoranHariIni;

    public $totalSetoranBulanIni;

    public function mount()
    {
        $this->user = Auth::user();

        $this->user->load('transaksiPenukaran');

        $this->totalPendapatan = $this->user->transaksiPenukaran->sum('total_harga');
        $this->totalBeratSampah = $this->user->transaksiPenukaran->sum('total_berat');
        $this->totalSetoranHariIni = $this->user->transaksiPenukaran()
            ->whereDate('created_at', now()->toDateString())->count();
        $this->totalSetoranBulanIni = $this->user->transaksiPenukaran()
            ->whereMonth('created_at', now()->month)->count();
    }

    #[Layout('components.layouts.dashboard')]
    #[Title('Dashboard - Bank Sampah')]
    public function render()
    {
        return view('livewire.nasabah.dashboard');
    }
}
