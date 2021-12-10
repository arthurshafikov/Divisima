<?php

namespace App\Http\Controllers\Admin;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends CRUDController
{
    public function __construct()
    {
        $this->model = Post::class;
        $this->essense = 'posts';
        $this->td = ['id','title','image_tag'];
        $this->th = ['ID','Title','Image'];
        $this->oneText = 'Post';
    }

    protected function myValidate(Request $request): array
    {
        return $request->validate([
            'name' => 'required|string',
            'image_id' => 'nullable',
            'content' => '',
        ]);
    }
}
