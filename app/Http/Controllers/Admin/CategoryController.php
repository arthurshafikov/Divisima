<?php

namespace App\Http\Controllers\Admin;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends CRUDController
{
    public function __construct()
    {
        $this->model = Category::class;
        $this->routePrefix = 'categories';
        $this->tableData = ['id','name'];
        $this->tableHeaders = ['ID','Name'];
        $this->title = 'Category';
    }

    protected function myValidate(Request $request): array
    {
        return $request->validate([
            'parent_id' => 'nullable|numeric',
            'name' => 'required|string',
        ]);
    }
}
