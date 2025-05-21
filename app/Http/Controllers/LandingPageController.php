<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class LandingPageController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $posts = Post::with('images')->latest()->limit(3)
            ->get()->map(function ($post) {
                if ($post->konten) {
                    $post->konten = preg_replace('/<figure.*?>.*?<\/figure>/is', '', $post->konten);

                    $post->konten = preg_replace('/<a href="[^"]*"><img[^>]*>*<span>[^<]*<\/span><\/a>/is', '', $post->konten);

                    $post->konten = preg_replace('/(>)(\S)/', '$1 $2', $post->konten);
                }
                return $post;
            });

        return view('welcome', compact('posts'));
    }
}
