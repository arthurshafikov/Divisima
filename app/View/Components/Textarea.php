<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Textarea extends Component
{
    public $name;
    public $label;
    public $placeholder;
    public $value;
    public $id;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($id = '',$name = 'content',$label = '',$placeholder = '',$value = '')
    {
        $this->name = $name;
        $this->label = $label;
        $this->placeholder = $placeholder;
        $this->value = $value;
        $this->id = $id;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('admin.components.textarea');
    }
}
