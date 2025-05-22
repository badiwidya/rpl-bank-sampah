<?php

namespace App\Livewire\Admin;

use App\Models\Category;
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

class CreatePost extends Component
{
    use WithFileUploads;

    public $user;

    #[Validate]
    public $postTitle = '';
    public $categories;

    public $categorySelected;
    public $content = '';
    public $temporaryImages = [];

    protected function rules()
    {
        return [
            'postTitle' => 'required|string|min:4|max:255',
            'categorySelected' => 'required',
            'content' => ['required']
        ];
    }

    protected function validationAttributes()
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
            if (!$path) {
                return ['error' => 'URL gambar tidak valid'];
            }
            
            $filename = basename($path);
            
            foreach ($this->temporaryImages as $index => $tempPath) {
                if (basename($tempPath) === $filename) {
                    $actualPath = $this->temporaryImages[$index];
                    
                    array_splice($this->temporaryImages, $index, 1);
                    
                    if (Storage::disk('public')->exists($actualPath)) {
                        Storage::disk('public')->delete($actualPath);
                        return ['success' => true];
                    }
                }
            }
            
            return ['success' => false, 'error' => 'Gambar tidak ditemukan'];
        } catch (\Exception $e) {
            return ['error' => 'Gagal menghapus gambar: ' . $e->getMessage()];
        }
    }

    public function save()
    {
        $this->validate();
        try {

            $cleanContent = Purifier::clean($this->content);

            $post = $this->user->posts()->create([
                'judul' => $this->postTitle,
                'konten' => $cleanContent,
                'category_id' => $this->categorySelected
            ]);
            
            foreach ($this->temporaryImages as $imagePath) {
                PostImage::create([
                    'post_id' => $post->id,
                    'image_url' => $imagePath
                ]);
            }

            Redirect::route('admin.dashboard.post')->success('Berhasil membuat postingan baru!');
        } catch (\Throwable $e) {
            Toaster::error('Terjadi kesalahan saat membuat postingan: ' . $e->getMessage());
        }
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
