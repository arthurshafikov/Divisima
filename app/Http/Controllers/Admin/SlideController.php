<?php

namespace App\Http\Controllers\Admin;

use App\Models\Slide;
use Illuminate\Http\Request;

class SlideController extends CRUDController
{
    public function __construct()
    {
        $this->model = Slide::class;
        $this->routePrefix = 'slider';
        $this->tableData = ['id','title','image_tag'];
        $this->tableHeaders = ['ID','Title','Image'];
        $this->title = 'Slide';
    }

    protected function myValidate(Request $request): array
    {
        return $request->validate([
            'title' => 'required|string',
            'content' => 'nullable|string',
            'image_id' => 'nullable',
        ]);
    }
}
