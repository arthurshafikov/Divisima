<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\View\View;

class PostController extends Controller
{
    public function blog(): View
    {
        $posts = Post::orderBy('created_at', 'desc')->paginate(10);
        return view('blog.blog', [
            'title' => 'Blog page',
            'posts' => $posts,
        ]);
    }

    public function one(string $slug): View
    {
        $post = Post::whereSlug($slug)->firstOrFail();
        return view('blog.one', [
            'title' => $post->title,
            'post' => $post,
        ]);
    }
}
