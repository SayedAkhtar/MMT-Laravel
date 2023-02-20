<?php

namespace App\Http\Livewire;

use App\Models\Query;
use App\Models\User;
use Illuminate\Support\Collection;
use Livewire\Component;

class AssignCordinatorToQuery extends Component
{
    protected Query $query;
    public String $coordinator_id, $name, $email, $phone, $languages, $search;
    public array $results;
    public function mount(Query $query)
    {
        $this->query = $query;
        if(!empty($this->query->confirmedQuery) && !empty($this->query->confirmedQuery->coordinator_id)){
            $this->coordinator_id = $this->query->confirmedQuery->coordinator_id;
            $this->name = $this->query->confirmedQuery->coordinator->name;
            $this->email = $this->query->confirmedQuery->coordinator->email;
            $this->phone = $this->query->confirmedQuery->coordinator->phone;
        }

    }

    public function search()
    {
        $this->results = User::where('name', '<>',$this->search)->get()->toArray();
    }

    public function select(User $user)
    {
        $this->coordinator_id = $user->id;
        $this->name = $user->name;
        $this->email = $user->email;
        $this->phone = $user->phone;
        $this->languages = "";
        $this->results = [];
    }

    public function render()
    {
        return view('livewire.assign-cordinator-to-query');
    }
}