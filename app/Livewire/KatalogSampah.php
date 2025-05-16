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

    public bool $editModal = false;
    public ?Sampah $sampahToEdit;

    public bool $createModal = false;
    public $dataInput = [
        'nama' => '',
        'harga_per_kg' => '',
    ];

    protected $rules = [
        'dataInput.nama' => 'required|string|max:255',
        'dataInput.harga_per_kg' => 'required|numeric|min:0',
    ];

    protected $validationAttributes = [
        'dataInput.nama' => 'nama',
        'dataInput.harga_per_kg' => 'harga per kg',
    ];

    public function editSampah(Sampah $sampah)
    {
        $this->authorize('update', $sampah);
        $this->sampahToEdit = $sampah;
        $this->dataInput['harga_per_kg'] = $sampah->harga_per_kg;
        $this->dataInput['nama'] = $sampah->nama;
        $this->editModal = true;
    }

    public function update()
    {
        $this->authorize('update', $this->sampahToEdit);
        $this->validate();
        try {
            $this->sampahToEdit->update($this->dataInput);
            $this->editModal = false;
            $this->sampahToEdit = null;
            Toaster::success('Sampah berhasil diperbarui');
        } catch (\Exception $e) {
            Toaster::error('Terjadi kesalahan saat memperbarui sampah');
        }
    }

    public function confirmDelete(Sampah $sampah)
    {
        $this->authorize('delete', $sampah);

        $this->deleteConfirmation = true;
        $this->sampahToDelete = $sampah;
    }

    public function delete()
    {
        $this->authorize('delete', $this->sampahToDelete);

        try {

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
