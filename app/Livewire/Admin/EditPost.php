<?php

namespace App\Livewire\Admin;

use App\Models\Category;
use App\Models\Post;
use App\Models\PostImage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;
use Masmerise\Toaster\Toaster;
use Mews\Purifier\Facades\Purifier;

class EditPost extends Component
{
    use WithFileUploads;

    public $post;
    public $user;

    #[Validate]
    public $postTitle = '';
    public $categories;

    public $categorySelected;
    public $content = '';
    public $temporaryImages = [];
    public $existingImages = [];

    public function rules()
    {
        return [
            'postTitle' => 'required|string|min:4|max:255',
            'categorySelected' => 'required',
            'content' => ['required']
        ];
    }

    public function validationAttributes()
    {
        return [
            'postTitle' => 'Judul postingan',
            'categorySelected' => 'Kategori',
            'content' => 'Isi postingan'
        ];
    }


    public function uploadImage($fileData)
    {
        try {
            $base64Image = explode(',', $fileData)[1] ?? null;
            if (!$base64Image) {
                return ['error' => 'Format gambar tidak valid'];
            }
            
            $imageData = base64_decode($base64Image);
            
            $filename = 'post_' . time() . '_' . rand(1000, 9999) . '.jpg';
            $path = 'posts/' . $filename;
            
            Storage::disk('public')->put($path, $imageData);
            
            $this->temporaryImages[] = $path;
            
            $url = Storage::disk('public')->url($path);
            return [
                'url' => $url,
                'path' => $path
            ];
            
        } catch (\Exception $e) {
            return ['error' => 'Gagal mengunggah gambar: ' . $e->getMessage()];
        }
    }

    public function deleteImage($imageUrl)
    {
        try {
            $path = parse_url($imageUrl, PHP_URL_PATH);
            if (!$path) return ['error' => 'URL gambar tidak valid'];
            
            $filename = basename($path);
            
            $actualPath = null;
            
            $tempIndex = array_search('posts/' . $filename, $this->temporaryImages);
            if ($tempIndex !== false) {
                $actualPath = $this->temporaryImages[$tempIndex];
                array_splice($this->temporaryImages, $tempIndex, 1);
            } else {
                $postImage = PostImage::where('post_id', $this->post->id)
                    ->where('image_url', 'like', '%' . $filename . '%')
                    ->first();
                
                if ($postImage) {
                    $actualPath = $postImage->image_url;
                    $postImage->delete();
                }
            }
            
            if ($actualPath && Storage::disk('public')->exists($actualPath)) {
                Storage::disk('public')->delete($actualPath);
                return ['success' => true];
            }
            
            return ['success' => false, 'error' => 'Gambar tidak ditemukan'];
        } catch (\Exception $e) {
            return ['error' => 'Gagal menghapus gambar: ' . $e->getMessage()];
        }
    }
    
    public function update()
    {
        $this->validate();
        try {

            $cleanContent = Purifier::clean($this->content);

            $this->post->update([
                'judul' => $this->postTitle,
                'konten' => $cleanContent,
                'category_id' => $this->categorySelected
            ]);

            foreach ($this->temporaryImages as $imagePath) {
                PostImage::create([
                    'post_id' => $this->post->id,
                    'image_url' => $imagePath
                ]);
            }

            $this->cleanupOrphanedImages();

            Redirect::route('admin.dashboard.post')->success('Berhasil memperbarui postingan!');
        } catch (\Throwable $e) {
            Toaster::error('Terjadi kesalahan saat memperbarui postingan: ' . $e->getMessage());
        }
    }
    
    protected function cleanupOrphanedImages()
    {
        $postImages = $this->post->images;
        
        preg_match_all('/<img[^>]+src="([^">]+)"/', $this->content, $matches);
        $contentImageUrls = $matches[1] ?? [];
        
        foreach ($postImages as $postImage) {
            $imageUrl = Storage::disk('public')->url($postImage->image_url);
            $isOrphaned = true;
            
            foreach ($contentImageUrls as $contentUrl) {
                if (strpos($contentUrl, basename($postImage->image_url)) !== false) {
                    $isOrphaned = false;
                    break;
                }
            }
            
            if ($isOrphaned) {
                if (Storage::disk('public')->exists($postImage->image_url)) {
                    Storage::disk('public')->delete($postImage->image_url);
                }
                
                $postImage->delete();
            }
        }
    }

    public function mount(Post $post)
    {
        $this->user = Auth::user();
        if ($this->user->role !== 'admin') abort(403, "Unauthorized");

        $this->post = $post;
        $this->postTitle = $post->judul;
        $this->content = $post->konten;
        $this->categorySelected = $post->category_id;
        
        $this->existingImages = $post->images->pluck('image_url')->toArray();

        $this->categories = Category::all();
    }

    #[Layout('components.layouts.dashboard')]
    #[Title('Edit Postingan - Bank Sampah')]
    public function render()
    {
        return view('livewire.admin.edit-post');
    }
}
