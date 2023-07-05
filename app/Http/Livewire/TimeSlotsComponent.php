<?php

namespace App\Http\Livewire;

use Livewire\Component;

class TimeSlotsComponent extends Component
{
    public $slots = "";

    public function mount($slots = "")
    {
        $this->slots = $slots;
    }

    public function addSlot(string $day, string $slot)
    {
        $temp = json_decode($this->slots, true);
        $temp[$day][] = $slot;
        $this->slots = json_encode($temp);
    }

    public function deleteSlot(string $day, int $index)
    {
        $temp = json_decode($this->slots, true);
        unset($temp[$day][$index]);
        $this->slots = json_encode($temp);
    }

    public function render()
    {
        return view('livewire.time-slots-component');
    }
}
