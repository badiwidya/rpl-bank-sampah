<?php

namespace App\Livewire;

use App\Models\Sampah;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use Masmerise\Toaster\Toaster;

class KatalogSampah extends Component
{
    use WithPagination, WithFileUploads;
    #[Url('query')]
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

    public $imageUpload = null;
    public $imagePath = null;

    public $mode = '';

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
        $this->imagePath = $sampah->image_url;
        $this->mode = 'edit';
        $this->imageUpload = null;
        $this->editModal = true;
    }

    public function createSampah()
    {
        $this->authorize('create', Sampah::class);
        $this->mode = 'create';
        $this->resetInput();
        $this->editModal = true;
    }

    public function store()
    {
        $this->authorize('create', Sampah::class);
        $this->trimInput();
        $this->validate();
        $this->validate([
            'imageUpload' => 'required|mimes:jpg,jpeg,png|max:4096',
        ]);
        try {
            $this->dataInput['image_url'] = $this->imageUpload->store('sampah', 'public');
            Sampah::create($this->dataInput);
            $this->editModal = false;
            $this->resetInput();
            Toaster::success('Sampah berhasil ditambahkan');
        } catch (\Exception $e) {
            Toaster::error('Terjadi kesalahan saat menambahkan sampah');
        }
    }

    public function update()
    {
        $this->authorize('update', $this->sampahToEdit);
        $this->trimInput();
        $this->validate();
        $this->validate([
            'imageUpload' => 'nullable|sometimes|mimes:jpg,jpeg,png|max:4096',
        ]);
        try {

            if ($this->imageUpload) {
                $this->dataInput['image_url'] = $this->imageUpload->store('sampah', 'public');
            }

            $this->sampahToEdit->update($this->dataInput);
            $this->editModal = false;
            $this->sampahToEdit = null;
            $this->resetInput();
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
            if ($this->sampahToDelete->image_url) {
                Storage::disk('public')->delete($this->sampahToDelete->image_url);
            }
            $this->sampahToDelete->delete();
            $this->deleteConfirmation = false;
            $this->sampahToDelete = null;
            Toaster::success('Sampah berhasil dihapus');
        } catch (\Exception $e) {
            Toaster::error('Terjadi kesalahan saat menghapus sampah');
        }
    }

    public function resetInput()
    {
        $this->imageUpload = null;
        $this->imagePath = null;
        $this->dataInput = [
            'nama' => '',
            'harga_per_kg' => '',
        ];
    }

    public function trimInput()
    {
        $this->dataInput['nama'] = str(trim($this->dataInput['nama']))->squish()->toString();
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

    #[Layout('components.layouts.dashboard')]
    #[Title('Katalog Sampah - Bank Sampah')]
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
