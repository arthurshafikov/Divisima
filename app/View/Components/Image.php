<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Image extends Component
{
    public string $label;
    public string $name;
    public string $input_id;
    public string $value;
    public string $selectText;
    public string $src;
    public string $img_id;

    public function __construct(
        $label = 'Image',
        $name = 'img',
        $input_id = 'featured_img',
        $value = '',
        $selectText = 'Select Images',
        $src = '',
        $img_id = 'featured_preview'
    ) {
        $this->label = $label;
        $this->name = $name;
        $this->input_id = $input_id;
        $this->value = $value;
        $this->selectText = $selectText;
        $this->src = $src;
        $this->img_id = $img_id;
    }

    public function render()
    {
        return view('admin.components.image');
    }
}
