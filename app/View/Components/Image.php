<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Image extends Component
{
    public string $label;
    public string $name;
    public string $inputId;
    public mixed $value;
    public string $selectText;
    public mixed $src;
    public string $imgId;

    public function __construct(
        $label = 'Image',
        $name = 'img',
        $inputId = 'featured_img',
        $value = '',
        $selectText = 'Select Images',
        $src = '',
        $imgId = 'featured_preview'
    ) {
        $this->label = $label;
        $this->name = $name;
        $this->inputId = $inputId;
        $this->value = $value;
        $this->selectText = $selectText;
        $this->src = $src;
        $this->imgId = $imgId;
    }

    public function render()
    {
        return view('admin.components.image');
    }
}
