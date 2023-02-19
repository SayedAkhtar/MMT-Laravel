<?php

namespace App\Http\Livewire;

use Livewire\Component;

class TimeSlotsComponent extends Component
{
    public $slots = [];
    public function addSlot($slot)
    {
        $this->slots []= $slot;
    }
    public function deleteSlot($index)
    {
        unset($this->slots[$index]);
    }
    public function render()
    {
        return view('livewire.time-slots-component');
    }
}