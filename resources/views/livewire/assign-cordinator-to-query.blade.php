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
    <input type="hidden" name="coordinator_id" value="{{ $coordinator_id }}">
    <div class="form-group">
        <label for="inputName">Name</label>
        <input type="text" class="form-control" value="{{ $name  }}" readonly>
    </div>
    <div class="form-group">
        <label for="inputDescription">Email</label>
        <input type="text" id="inputName" class="form-control" value="{{ $email }}" readonly>
    </div>
    <div class="form-group">
        <label for="inputDescription">Phone Number</label>
        <input type="text" id="inputName" class="form-control" value="{{ $phone }}" readonly>
    </div>
    <div class="form-group">
        <label for="inputDescription">Languages Spoken</label>
        <input type="text" id="inputName" class="form-control" value="{{ $languages }}" readonly>
    </div>

</div>