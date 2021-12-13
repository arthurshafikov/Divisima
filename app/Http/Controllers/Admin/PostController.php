<?php

namespace App\Http\Controllers\Admin;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends CRUDController
{
    public function __construct()
    {
        $this->model = Post::class;
        $this->routePrefix = 'posts';
        $this->tableData = ['id','title','image_tag'];
        $this->tableHeaders = ['ID','Title','Image'];
        $this->title = 'Post';
    }

    protected function myValidate(Request $request): array
    {
        return $request->validate([
            'name' => 'required|string',
            'content' => 'required|string',
            'image_id' => 'nullable',
        ]);
    }
}
