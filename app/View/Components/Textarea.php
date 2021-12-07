<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Textarea extends Component
{
    public string $name;
    public string $label;
    public string $placeholder;
    public mixed $value;
    public string $id;

    public function __construct(
        string $id = '',
        string $name = 'content',
        string $label = '',
        string $placeholder = '',
        mixed $value = ''
    ) {
        $this->name = $name;
        $this->label = $label;
        $this->placeholder = $placeholder;
        $this->value = $value;
        $this->id = $id;
    }

    public function render()
    {
        return view('admin.components.textarea');
    }
}
