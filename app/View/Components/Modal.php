<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Modal extends Component
{
    public String $form_id;
    public $title;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($title=" Default Modal ")
    {
        $this->form_id = $type;
        $this->title = $title;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.modal');
    }
}