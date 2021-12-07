<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Select extends Component
{
    public string $name;
    public mixed $array;
    public mixed $compared;
    public string $label;
    public string $default;
    public string $field;
    public string $labelField;

    public function __construct(
        string $name,
        mixed $array,
        mixed $compared,
        string $label = '',
        string $default = '',
        string $field = 'id',
        string $labelField = 'name'
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
