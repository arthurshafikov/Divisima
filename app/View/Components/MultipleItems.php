<?php

namespace App\View\Components;

use Illuminate\View\Component;

class MultipleItems extends Component
{
    public $name;
    public $post;
    public $iterable;
    public $placeholder;
    public $columns;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($name, $post, $iterable, $pholder, $columns = false)
    {
        $this->name = $name;
        $this->post = $post;
        $this->iterable = $iterable;
        $this->placeholder = $pholder;
        $this->columns = $columns;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('admin.components.multiple-items');
    }
}
