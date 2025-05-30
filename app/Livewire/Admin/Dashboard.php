<?php

namespace App\Livewire\Admin;

use App\Models\TransaksiPenarikan;
use App\Models\TransaksiPenukaran;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

class Dashboard extends Component
{
    public $user;
    public $setoranBulanIni;
    public $nasabahTotal;
    public $sampahTotal;

    public $setoranSampahTerkini;
    public $permintaanPenarikanPending;

    public function mount()
    {
        $this->user = Auth::user();
        $this->sampahTotal = TransaksiPenukaran::all()->sum('total_berat');
        $this->nasabahTotal = User::where('role', 'nasabah')->count();
        $this->setoranBulanIni = TransaksiPenukaran::whereMonth('created_at', now()->month)->count();

        $this->setoranSampahTerkini = TransaksiPenukaran::with('nasabah')->latest()->limit(5)->get();
        $this->permintaanPenarikanPending = TransaksiPenarikan::where('status', 'pending')->latest()->limit(5)->get();
    }

    #[Layout('components.layouts.dashboard')]
    #[Title('Dashboard - Bank Sampah')]
    public function render()
    {
        return view('livewire.admin.dashboard');
    }
}
