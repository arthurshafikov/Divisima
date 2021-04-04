<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\Slide;

class SlideController extends CRUDController
{
    public function __construct()
    {
        $this->model = Slide::class;
        $this->essense = 'slider';
        $this->td = ['id','title','image_tag'];
        $this->th = ['ID','Title','Image'];
        $this->oneText = 'Slide';
    }
    
    protected function myValidate(Request $request)
    {
        return $request->validate([
            'title' => 'required|string',
            'img' => 'nullable',
        ]);
    }
}
