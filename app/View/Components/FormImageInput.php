<?php

namespace App\View\Components;

use Illuminate\View\Component;

class FormImageInput extends Component
{
    public $label, $name;
    public bool $multiple;
    public $defaultImages;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(string $label, string $name, $multiple = false, $defaultImages = "")
    {
        $this->label = $label;
        $this->name = $multiple ? $name . '[]' : $name;
        $this->multiple = $multiple;
        $this->defaultImages = is_array($defaultImages) ? $defaultImages : (!empty($defaultImages) ? [$defaultImages] : []);
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.form-image-input');
    }
}
