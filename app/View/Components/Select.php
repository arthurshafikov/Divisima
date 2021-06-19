<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Select extends Component
{
    public string $name;
    public string $default;
    public string $field;
    public array $array;
    public string $compared;
    public string $label;
    public string $labelField;

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

    public function render()
    {
        return view('admin.components.select');
    }

    public function echoSelectedIfEquals($option)
    {
        if ($option == $this->compared) {
            return 'selected';
        }
        return '';
    }
}
