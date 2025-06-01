<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Category;
use Illuminate\Http\Request;

class PostinganController extends Controller
{
    public function index(Request $request)
    {
        $posts = Post::with(['author', 'category', 'images']);

        if ($request->has('category') && $request->category != '') {
            $posts->whereHas('category', function ($query) use ($request) {
                $query->where('slug', $request->category);
            });
        }

        if ($request->has('search') && $request->search != '') {
            $searchTerm = '%' . $request->search . '%';
            $posts->where(function ($query) use ($searchTerm) {
                $query->where('judul', 'like', $searchTerm)
                    ->orWhere('konten', 'like', $searchTerm);
            });
        }

        $sortField = $request->sort ?? 'created_at';
        $sortDirection = $request->direction ?? 'desc';

        $allowedSortFields = ['judul', 'created_at', 'updated_at'];
        if (!in_array($sortField, $allowedSortFields)) {
            $sortField = 'created_at';
        }

        $allowedDirections = ['asc', 'desc'];
        if (!in_array($sortDirection, $allowedDirections)) {
            $sortDirection = 'desc';
        }

        $posts->orderBy($sortField, $sortDirection);

        $posts = $posts
            ->paginate(10)
            ->through(function ($post) {
                if ($post->konten) {
                    $post->konten = preg_replace('/<figure.*?>.*?<\/figure>/is', '', $post->konten);

                    $post->konten = preg_replace('/<a href="[^"]*"><img[^>]*>*<span>[^<]*<\/span><\/a>/is', '', $post->konten);

                    $post->konten = preg_replace('/(>)(\S)/', '$1 $2', $post->konten);
                }
                return $post;
            })
            ->withQueryString();

        $categories = Category::orderBy('nama')->get();

        return view('index-post', [
            'posts' => $posts,
            'categories' => $categories,
            'currentCategory' => $request->category ?? null,
            'currentSort' => $sortField,
            'currentDirection' => $sortDirection,
            'search' => $request->search ?? ''
        ]);
    }

    public function show(Post $post)
    {
        $post->load(['author', 'category', 'images']);

        $relatedPosts = Post::where('category_id', $post->category_id)
            ->where('id', '!=', $post->id)
            ->latest()
            ->limit(4)
            ->get();

        return view('show-post', [
            'post' => $post,
            'relatedPosts' => $relatedPosts
        ]);
    }
}
