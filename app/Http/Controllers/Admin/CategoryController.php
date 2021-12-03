<?php

namespace App\Http\Controllers\Admin;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends CRUDController
{
    public function __construct()
    {
        $this->model = Category::class;
        $this->essense = 'categories';
        $this->td = ['id','name'];
        $this->th = ['ID','Name'];
        $this->oneText = 'Category';
    }

    protected function myValidate(Request $request)
    {
        return $request->validate([
            'name' => 'required|string',
        ]);
    }
}
