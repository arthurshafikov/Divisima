<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Input extends Component
{

    public $name;
    public $value;
    public $type;
    public $placeholder;
    public $label;
    public $class;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($name = 'name',$value = '',$type = 'text',$pholder = '',$label = '',)
    {
        $this->name = $name;
        $this->value = $value;
        $this->type = $type;
        $this->placeholder = $pholder;
        $this->label = $label;

        if($type != 'checkbox'){
            $this->class = 'form-control';
        }
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {

        return view('admin.components.input');
    }
}
