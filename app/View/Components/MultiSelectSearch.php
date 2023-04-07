<?php

namespace App\View\Components;

use Illuminate\View\Component;

class MultiSelectSearch extends Component
{
    public $name;
    public $table;
    public $label;
    public bool $multiple;
    public $selectedOptions;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(string $name, string $label, string $table, $selectedOptions = [], bool $multiple = true)
    {
        $this->name = $name;
        $this->table = $table;
        $this->label = $label;
        $this->multiple = $multiple;
        $this->selectedOptions = is_array($selectedOptions) ? $selectedOptions : [$selectedOptions];
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.multi-select-search');
    }
}
