<?php

namespace App\Livewire\Admin;

use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

class ManagePost extends Component
{
    public $term = '';
    public $sortField;
    public $sortDirection = 'asc';
    public $dateFilter = '';
    public $categoryFilter;

    #[Layout('components.layouts.dashboard')]
    #[Title('Kelola Postingan - Bank Sampah')]
    public function render()
    {
        return view('livewire.admin.manage-post');
    }
}
