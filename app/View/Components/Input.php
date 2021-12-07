<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Input extends Component
{
    public string $name;
    public mixed $value;
    public string $type;
    public string $placeholder;
    public string $label;
    public string $class;

    public function __construct(
        string $name = 'name',
        mixed $value = '',
        string $type = 'text',
        string $pholder = '',
        string $label = ''
    ) {
        $this->name = $name;
        $this->value = $value;
        $this->type = $type;
        $this->placeholder = $pholder;
        $this->label = $label;
        $this->class = '';

        if ($type != 'checkbox') {
            $this->class = 'form-control';
        }
    }

    public function render()
    {
        return view('admin.components.input');
    }
}
