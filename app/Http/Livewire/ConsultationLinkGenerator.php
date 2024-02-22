<?php

namespace App\Http\Livewire;

use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use Livewire\Component;

class ConsultationLinkGenerator extends Component
{
    public $userType = "";
    public $channelName = "";
    public $links = [];

    public function mount(string $channelName){
        $this->channelName = $channelName;
        foreach([3,4,5] as $userType){
            $this->links[$userType] = base64_encode($this->channelName.'#'.$userType);
        }
    }

    public function save()
    {
        $string = base64_encode($this->channelName.'#'.$this->userType);
        $links = Cache::get($this->channelName);
        $this->links[$this->userType] = $string;
    }

    public function render()
    {
        return view('livewire.consultation-link-generator');
    }
}
