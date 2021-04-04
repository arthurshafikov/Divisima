<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Select extends Component
{
    public $name;
    public $default;
    public $field;
    public $array;
    public $compared;
    public $label;
    public $labelField;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(
        $name, 
        $array, 
        $compared, 
        $label = '', 
        $default = false, 
        $field = 'id', 
        $labelField = 'name'
    ) {
        $this->name = $name;
        $this->array = $array;
        $this->compared = $compared;
        $this->label = $label;
        $this->field = $field;
        $this->labelField = $labelField;
        $this->default = $default;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('admin.components.select');
    }

    public function echoSelectedIfEquals($option)
    {
        if ($option == $this->compared) 
            return 'selected';
        return '';
    }   
}
