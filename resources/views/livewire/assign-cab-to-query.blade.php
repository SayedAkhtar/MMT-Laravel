<div>
    <form wire:submit.prevent="submit" action="">

        <div class="form-group">
            <label for="inputEstimatedBudget">Name</label>
            <input type="text" name="name" class="form-control" wire:model="name">
        </div>
        <div class="form-group">
            <label for="inputEstimatedBudget">Car Number</label>
            <input type="text" class="form-control" name="car_number" wire:model="number">
        </div>
        <div class="form-group">
            <label for="inputEstimatedBudget">Car Type</label>
            <input type="text" class="form-control" name="car_type" wire:model="type">
        </div>
        <div class="form-group">
            <button class="btn btn-outline-success btn-submit" >Submit</button>
        </div>
    </form>
</div>