<?php

namespace App\View\Components;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\View\Component;

class MultiSelectSearch extends Component
{
    public $name;
    public $table;
    public $label;
    public bool $multiple;
    public $selectedOptions;
    public bool $shouldInsert;
    public bool $required;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(string $name, string $label, string $table, $selectedOptions = [], bool $multiple = true, bool $shouldInsert = false, bool $required = false)
    {
        $this->name = $name;
        $this->table = $table;
        $this->label = $label;
        $this->multiple = $multiple;
        if ($selectedOptions instanceof Collection) {
            $temp = [];
            foreach ($selectedOptions as $option) {
                $temp[] = $option;
            }
            $selectedOptions = $temp;
        }
        $this->selectedOptions = is_array($selectedOptions) ? $selectedOptions : [$selectedOptions];
        $this->shouldInsert = $shouldInsert;
        $this->required = $required;
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
