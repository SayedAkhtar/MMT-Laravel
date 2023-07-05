<div class="card-body">
    <div class="form-group">
        <label for="inputName">Search Coordinator</label>
        <input type="text" class="form-control" wire:keyup="search" value="" wire:model="search">
        @if(!empty($results))
            <span class="livewire-search-results">
            <ul>
                @foreach($results as $user)
                    <li wire:click="select({{ $user["id"] }})"> {{ $user["name"] }} : {{ $user["email"] }}</li>
                @endforeach

            </ul>
        </span>
        @endif
    </div>


</div>
