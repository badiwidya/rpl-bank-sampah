<?php

namespace App\Livewire;

use App\Models\TransaksiPenarikan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;
use Masmerise\Toaster\Toaster;

class PenarikanSaldo extends Component
{
    use WithPagination;

    public $term = '';
    public $sortField;
    public $sortDirection = 'asc';
    public $dateFilter = '';
    public $status = '';
    public $penarikan;

    public function rejectWithdraw(TransaksiPenarikan $transaksi)
    {
        try {
            $transaksi->update([
                'status' => 'rejected'
            ]);

            Toaster::success('Berhasil menolak permintaan penarikan!');
        } catch (\Throwable $e) {
            Toaster::error('Terjadi kesalahan saat menolak permintaan penarikan.');
        }
    }

    public function approveWithdraw(TransaksiPenarikan $transaksi)
    {
        try {
            DB::transaction(function () use ($transaksi) {
                $user = $transaksi->nasabah;

                $user->profile()->decrement('saldo', $transaksi->jumlah);

                $transaksi->update([
                    'status' => 'completed'
                ]);
            });

            Toaster::success('Berhasil menyelesaikan permintaan transaksi!');
        } catch (\Throwable $e) {
            Toaster::error('Terjadi kesalahan saat menyelesaikan permintaan penarikan.');
        }
    }

    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortField = $field;
            $this->sortDirection = 'asc';
        }
    }

    public function updatedTerm()
    {
        $this->resetPage();
    }

    public function seeDetail(TransaksiPenarikan $transaksi)
    {
        $transaksi->load('nasabah');

        $this->penarikan = $transaksi;
    }

    #[Layout('components.layouts.dashboard')]
    #[Title('Riwayat Penarikan - Bank Sampah')]
    public function render()
    {
        $query = TransaksiPenarikan::query();
        $user = Auth::user();

        if ($user->role === 'nasabah') {
            $query->where('user_id', $user->id);
        }

        if ($this->term) {
            $query->where(function ($q) {
                $q->whereHas(
                    'nasabah',
                    fn($q2) =>
                    $q2->where('nama_depan', 'like', '%' . $this->term . '%')
                        ->orWhere('nama_belakang', 'like', '%' . $this->term . '%')
                )->orWhere('metode_pembayaran', 'like', '%' . $this->term . '%')
                    ->orWhere('no_telepon', 'like', '%' . $this->term . '%')
                    ->orWhere('jumlah', 'like', '%' . $this->term . '%');
            });
        }

        if ($this->dateFilter === 'today') {
            $query->where('created_at', '>=', now()->toDateString());
        } else if ($this->dateFilter === 'month') {
            $query->where('created_at', '>=', now()->subMonth());
        } else if ($this->dateFilter === 'week') {
            $query->where('created_at', '>=', now()->subWeek());
        } else if ($this->dateFilter === 'year') {
            $query->where('created_at', '>=', now()->subYear());
        }

        if ($this->sortField && $this->sortDirection) {
            $query->orderBy($this->sortField, $this->sortDirection);
        } else {
            $query->latest();
        }

        if ($this->status) {
            $query->where('status', $this->status);
        }

        $riwayat = $query->with('nasabah')->paginate(5);


        return view('livewire.penarikan-saldo', compact('riwayat'));
    }
}
