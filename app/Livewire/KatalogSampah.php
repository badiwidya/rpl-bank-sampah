<?php

namespace App\Livewire;

use App\Models\Sampah;
use Livewire\Component;
use Livewire\WithPagination;
use Masmerise\Toaster\Toaster;

class KatalogSampah extends Component
{
    use WithPagination;

    public string $term = '';

    public string $sortField = 'harga_per_kg';

    public string $sortDirection = 'asc';

    public bool $deleteConfirmation = false;
    public ?Sampah $sampahToDelete;

    public function confirmDelete(Sampah $sampah)
    {
        $this->authorize('delete', $sampah);

        $this->deleteConfirmation = true;
        $this->sampahToDelete = $sampah;
    }
    public function delete()
    {
        try {
            $this->authorize('delete', $this->sampahToDelete);

            $this->sampahToDelete->delete();
            $this->deleteConfirmation = false;
            $this->sampahToDelete = null;
            Toaster::success('Sampah berhasil dihapus');
        } catch (\Exception $e) {
            Toaster::error('Terjadi kesalahan saat menghapus sampah');
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

    public function updatingTerm()
    {
        $this->resetPage();
    }

    public function render()
    {
        $query = Sampah::query();

        $jenisSampah = $query->where('nama', 'like', '%' . $this->term . '%')
            ->orWhere('harga_per_kg', 'like', '%' . $this->term . '%')
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate(10);

        return view('livewire.katalog-sampah', compact('jenisSampah'));
    }
}
