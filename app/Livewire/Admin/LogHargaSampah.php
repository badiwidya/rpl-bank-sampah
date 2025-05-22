<?php

namespace App\Livewire\Admin;

use App\Models\LogHargaSampah as LogHargaSampahModel;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class LogHargaSampah extends Component
{
    use WithPagination;

    #[Url('query')]
    public $term = '';
    public string $sortField = 'created_at';
    public string $sortDirection = 'desc';

    #[Layout('components.layouts.dashboard')]
    #[Title('Log Harga Sampah - Bank Sampah')]
    public function render()
    {
        $logs = LogHargaSampahModel::with(['sampah', 'admin'])
            ->when($this->term, function ($query) {
                return $query->whereHas('sampah', function ($q) {
                    $q->where('nama', 'like', '%' . $this->term . '%');
                });
            })
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate(10);

        return view('livewire.admin.log-harga-sampah', [
            'logs' => $logs,
        ]);
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
}
