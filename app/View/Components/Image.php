<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Image extends Component
{
    public $label;
    public $name;
    public $input_id;
    public $value;
    public $selectText;
    public $src;
    public $img_id;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($label = 'Image',$name = 'img',$input_id = 'featured_img',$value = '',$selectText = 'Select Images',$src = '',$img_id = 'featured_preview')
    {
        $this->label = $label;
        $this->name = $name;
        $this->input_id = $input_id;
        $this->value = $value;
        $this->selectText = $selectText;
        $this->src = $src;
        $this->img_id = $img_id;

    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('admin.components.image');
    }
}
