<?php

namespace App\Livewire\Admin;

use App\Models\Category;
use App\Models\Post;
use App\Models\PostImage;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;
use Masmerise\Toaster\Toaster;

class ManagePost extends Component
{
    use WithPagination;

    public $term = '';
    public $sortField = 'created_at';
    public $sortDirection = 'desc';
    public $sortOption = 'created_at-desc';
    public $dateFilter = '';
    public $categoryFilter;
    public $deleteConfirmation = false;
    public $selectedPost = null;
    public $categories = [];

    public function mount()
    {
        $this->categories = Category::all();
    }

    public function updatedTerm()
    {
        $this->resetPage();
    }

    public function updatedCategoryFilter()
    {
        $this->resetPage();
    }

    public function updatedDateFilter()
    {
        $this->resetPage();
    }

    public function updatedSortOption()
    {
        $parts = explode('-', $this->sortOption);
        if (count($parts) === 2) {
            $this->sortField = $parts[0];
            $this->sortDirection = $parts[1];
        }
        $this->resetPage();
    }

    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortField = $field;
            $this->sortDirection = 'asc';
        }

        $this->sortOption = "$this->sortField-$this->sortDirection";
    }

    public function confirmDelete($postId)
    {
        $this->selectedPost = $postId;
        $this->deleteConfirmation = true;
    }

    public function delete()
    {
        try {
            $post = Post::findOrFail($this->selectedPost);

            foreach ($post->images as $image) {
                if (Storage::disk('public')->exists($image->image_url)) {
                    Storage::disk('public')->delete($image->image_url);
                }
                $image->delete();
            }

            $post->delete();

            $this->deleteConfirmation = false;
            $this->selectedPost = null;

            Toaster::success('Postingan berhasil dihapus.');
        } catch (\Exception $e) {
            Toaster::error('Terjadi kesalahan saat menghapus postingan: ' . $e->getMessage());
        }
    }

    public function edit(Post $post)
    {
        try {
            return redirect()->route('admin.dashboard.post.edit', ['post' => $post]);
        } catch (\Exception $e) {
            Toaster::error('Post tidak ditemukan atau terjadi kesalahan.');
            return;
        }
    }

    #[Layout('components.layouts.dashboard')]
    #[Title('Kelola Postingan - Bank Sampah')]
    public function render()
    {
        if ($this->sortOption) {
            $parts = explode('-', $this->sortOption);
            if (count($parts) === 2) {
                $this->sortField = $parts[0];
                $this->sortDirection = $parts[1];
            }
        }

        $posts = Post::query()
            ->when($this->term, function ($query) {
                return $query->where(function ($q) {
                    $q->where('judul', 'like', '%' . $this->term . '%')
                        ->orWhere('konten', 'like', '%' . $this->term . '%');
                });
            })
            ->when($this->categoryFilter, function ($query) {
                return $query->where('category_id', $this->categoryFilter);
            })
            ->when($this->dateFilter, function ($query) {
                return match ($this->dateFilter) {
                    'today' => $query->whereDate('created_at', today()),
                    'week' => $query->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()]),
                    'month' => $query->whereMonth('created_at', now()->month)
                        ->whereYear('created_at', now()->year),
                    'year' => $query->whereYear('created_at', now()->year),
                    default => $query
                };
            })
            ->orderBy($this->sortField, $this->sortDirection)
            ->with(['author', 'category', 'images'])
            ->paginate(10)
            ->through(function ($post) {
                if ($post->konten) {
                    $post->konten = preg_replace('/<figure.*?>.*?<\/figure>/is', '', $post->konten);

                    $post->konten = preg_replace('/<a href="[^"]*"><img[^>]*>*<span>[^<]*<\/span><\/a>/is', '', $post->konten);

                    $post->konten = preg_replace('/(>)(\S)/', '$1 $2', $post->konten);
                }
                return $post;
            });

        return view('livewire.admin.manage-post', [
            'posts' => $posts,
        ]);
    }
}
