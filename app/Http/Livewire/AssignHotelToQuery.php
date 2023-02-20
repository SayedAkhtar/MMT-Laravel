<?php

namespace App\Http\Livewire;

use App\Models\Accommodation;
use Livewire\Component;

class AssignHotelToQuery extends Component
{
    protected String $query;
    public String $accommodation_id, $name, $address, $type, $languages, $search;
    public array $results;
    public function mount($query)
    {
        $this->query=$query;
        if(!empty($this->query->confirmedQuery) && !empty($this->query->confirmedQuery->accomomdation_id)){
            $this->coordinator_id = $this->query->confirmedQuery->accomomdation_id;
            $this->name = $this->query->confirmedQuery->accommodation->name;
            $this->address = $this->query->confirmedQuery->accommodation->address;
            $this->type = $this->query->confirmedQuery->accommodation->type;
        }
    }

    public function search()
    {
        $this->results = Accommodation::where('name', '<>',$this->search)->get()->toArray();
    }

    public function select(Accommodation $acc)
    {
        $this->accommodation_id = $acc->id;
        $this->name = $acc->name;
        $this->address = $acc->address;
        $this->type = $acc->type;
        $this->results = [];
    }

    public function render()
    {
        return view('livewire.assign-hotel-to-query');
    }
}