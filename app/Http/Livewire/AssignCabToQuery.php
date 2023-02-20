<?php

namespace App\Http\Livewire;

use App\Models\ConfirmedQuery;
use Livewire\Component;

class AssignCabToQuery extends Component
{
    public $query, $name, $number, $type;

    public function mount($query)
    {
        $this->query = $query;
    }

    public function submit()
    {
//        ConfirmedQuery::where('')
    }

    public function render()
    {
        return view('livewire.assign-cab-to-query');
    }
}