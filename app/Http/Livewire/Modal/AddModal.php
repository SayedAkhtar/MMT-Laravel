<?php

namespace App\Http\Livewire\Modal;

use Livewire\Component;

class AddModal extends Component
{
    public $index = 0;
    public function render()
    {
        return view('livewire.modal.add-modal');
    }

    public function addOne()
    {
        $this->index+=1;
    }
}