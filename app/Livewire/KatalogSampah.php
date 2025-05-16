<?php

namespace App\Livewire;

use App\Models\Sampah;
use Livewire\Component;
use Livewire\WithPagination;

class KatalogSampah extends Component
{
    use WithPagination;

    public string $term = '';

    public string $sortField = 'harga_per_kg';

    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortField = $field;
            $this->sortDirection = 'asc';
        }
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public string $sortDirection = 'asc';

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
