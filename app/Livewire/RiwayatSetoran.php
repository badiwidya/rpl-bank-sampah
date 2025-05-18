<?php

namespace App\Livewire;

use App\Models\TransaksiPenukaran;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class RiwayatSetoran extends Component
{
    use WithPagination;

    public $term = '';
    public $sortField;
    public $sortDirection = 'asc';
    public $dateFilter;

    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortField = $field;
            $this->sortDirection = 'asc';
        }
    }

    public function seeDetail($id) {
        $setoran = TransaksiPenukaran::with(['nasabah', 'sampah'])->findOrFail($id);

        // logika to be added
    }

    public function render()
    {
        $query = TransaksiPenukaran::query();
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
                )->orWhere('total_berat', 'like', '%' . $this->term . '%')
                    ->orWhere('total_harga', 'like', '%' . $this->term . '%')
                    ->orWhereHas(
                        'sampah',
                        fn($q3) =>
                        $q3->where('nama', 'like', '%' . $this->term . '%')
                    );
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

        $riwayat = $query->with(['nasabah', 'sampah'])->paginate(5);

        return view('livewire.riwayat-setoran', [
            'riwayat' => $riwayat
        ]);
    }
}
