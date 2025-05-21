<?php

namespace App\Livewire\Admin;

use App\Models\Category;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;

class CreatePost extends Component
{
    use WithFileUploads;

    public $user;

    #[Validate]
    public $postTitle = '';
    public $categories;

    public $categorySelected;
    public $content;
    public $coverImage;

    public function rules()
    {
        return [
            'postTitle' => 'required|string|min:4',
            'coverImage' => 'required|mimes:jpg,jpeg,png|max:9126',
            'content' => ['required']
        ];
    }

    public function mount()
    {
        $this->user = Auth::user();
        if ($this->user->role !== 'admin') abort(403, "Unauthorized");

        $this->categories = Category::all();
    }
    
    #[Layout('components.layouts.dashboard')]
    #[Title('Buat Postingan - Bank Sampah')]
    public function render()
    {
        return view('livewire.admin.create-post');
    }
}
