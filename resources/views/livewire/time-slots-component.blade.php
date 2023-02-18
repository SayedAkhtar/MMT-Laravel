<div>
    <label>Time Slots:</label>
    <input type="hidden" name="time_slots">

    <div class="row mb-3">
        @foreach($slots as $index => $slot)
            <div class="col-3">
                <div class="input-group">
                    <input type="text" class="form-control" value="{{ $slot }}" disabled>
                    <div class="input-group-append" wire:click="deleteSlot({{ $index }})">
                        <div class="btn btn-danger"><i class="fa fa-trash-alt"></i></div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    <div class="row">
        <div class="col-4">
            <div class="input-group date" id="time_slots" data-target-input="nearest">
                <input type="text" class="form-control datetimepicker-input"
                       data-target="#time_slots"/>
                <div class="input-group-append" data-target="#time_slots"
                     data-toggle="datetimepicker">
                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                </div>
                <div class="input-group-append">
                    <div class="btn btn-success" id="addSlot"><i class="fa fa-plus"></i></div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <script>
        $('#time_slots').datetimepicker({icons: {time: 'far fa-clock'}});
        $('#addSlot').on('click', function (e){
            let slot = $("input[data-target='#time_slots']").val();
            @this.addSlot(slot);
            $("input[data-target='#time_slots']").val('');
        })
    </script>
@endpush