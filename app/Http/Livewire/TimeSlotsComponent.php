<?php

namespace App\Http\Livewire;

use App\Models\TimeSlot;
use Illuminate\Support\Collection;
use Livewire\Component;

class TimeSlotsComponent extends Component
{
    public $slots = [];

    public function mount(Collection $slots)
    {
        $this->slots = $slots->toArray();
    }

    public function addSlot(string $day, string $slot)
    {
        foreach($this->slots  as $data){
            if($data['day'] == $day && $data['time'] == $slot){
                return;
            }
        }
        $this->slots[] = ['day' => $day, 'time' => $slot, 'timestamp' => TimeSlot::getTimestamp($slot)];
        // array_push($this->slots,$day." ".$slot);
    }

    public function deleteSlot(int $index)
    {
        $count = 0;
        $reduced_array = [];
        unset($this->slots[$index]);
        
    }

    public function render()
    {
        return view('livewire.time-slots-component');
    }
}
