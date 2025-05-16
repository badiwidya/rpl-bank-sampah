<?php

namespace App\Livewire;

use App\Models\Sampah;
use Livewire\Component;

class KatalogSampah extends Component
{

    public string $term = '';
    public function render()
    {
        $query = Sampah::query();

        $jenisSampah = $query->where('nama', 'like', '%' . $this->term . '%')
            ->orWhere('harga_per_kg', 'like', '%' . $this->term . '%')
            ->latest()
            ->paginate(10);

        return view('livewire.katalog-sampah', compact('jenisSampah'));
    }
}
