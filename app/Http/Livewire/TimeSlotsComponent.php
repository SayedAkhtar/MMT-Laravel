<?php

namespace App\Http\Livewire;

use Livewire\Component;

class TimeSlotsComponent extends Component
{
    public $slots = [];

    public function mount($slots = [])
    {
//        $temp = json_decode($slots);
//        foreach ($temp as $day => $time) {
//            $this->slots[$day] = $time;
//        }
        $this->slots = $slots;
    }

    public function addSlot(string $day, $slot)
    {
        $this->slots[$day][] = $slot;
    }

    public function deleteSlot($day, $index)
    {
        unset($this->slots[$day][$index]);
    }

    public function render()
    {
        return view('livewire.time-slots-component');
    }
}
