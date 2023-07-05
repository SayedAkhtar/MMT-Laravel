<div class="card-body">
    <div class="form-group">
        <label for="inputName">Search Accommodations</label>
        <input type="text" class="form-control" wire:keyup="search" value="" wire:model="search">
        @if(!empty($results))
            <span class="livewire-search-results">
            <ul>
                @foreach($results as $data)
                    <li wire:click="select({{ $data["id"] }})"> {{ $data["name"] }}</li>
                @endforeach

            </ul>
        </span>
        @endif
    </div>
    <input type="hidden" name="accommodation_id" value="{{ $accommodation_id }}">
    <div class="form-group">
        <label for="inputEstimatedBudget">Name</label>
        <input type="text" class="form-control" value="{{ $name }}" readonly>
    </div>
    <div class="form-group">
        <label for="inputEstimatedBudget">Address</label>
        <input type="text" class="form-control" value=" {{ $address }}" readonly>
    </div>
    <div class="form-group">
        <label for="inputEstimatedBudget">Type</label>
        <input type="text" class="form-control" value="{{ $type }}" readonly>
    </div>
</div>