<?php

namespace App\Livewire\Admin;

use Livewire\Component;

class CreatePost extends Component
{
    public $postTitle;
    public $categories;

    public $categorySelected;
    public $content;
    public $coverImage;
    
    public function render()
    {
        return view('livewire.admin.create-post');
    }
}
