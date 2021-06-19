<?php

namespace App\View\Components;

use Illuminate\View\Component;

class MultipleItems extends Component
{
    public mixed $name;
    public string $post;
    public string $iterable;
    public string $placeholder;
    public string $columns;

    public function __construct($name, $post, $iterable, $pholder, $columns = '')
    {
        $this->name = $name;
        $this->post = $post;
        $this->iterable = $iterable;
        $this->placeholder = $pholder;
        $this->columns = $columns;
    }

    public function render()
    {
        return view('admin.components.multiple-items');
    }
}
