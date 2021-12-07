<?php

namespace App\View\Components;

use Illuminate\View\Component;

class MultipleItems extends Component
{
    public mixed $name;
    public mixed $post;
    public ?string $iterable;
    public mixed $placeholder;
    public mixed $columns;

    public function __construct(mixed $name, mixed $post, ?string $iterable, mixed $pholder, mixed $columns = '')
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
