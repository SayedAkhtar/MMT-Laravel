<div>
    <label>Time Slots:</label>
    @if(!empty($slots))
        <input type="hidden" name="time_slots" value="{{ !empty($slots)?json_encode($slots):'' }}" required>
    @endif
    @php
        if(gettype($slots) == "string"){
            $slots = json_decode($slots);
        }
    @endphp
    @if(!empty($slots))
        @foreach($slots as $day => $slot)
            <div class="row mb-3">
                @foreach($slot as $index => $time)
                    <div class="col-3">
                        <div class="input-group">
                            <input type="text" class="form-control text-capitalize" value="{{ $day." ".$time }}"
                                   disabled/>
                            <div class="input-group-append" wire:click="deleteSlot('{{$day}}' ,{{ $index }})">
                                <div class="btn btn-danger"><i class="fa fa-trash-alt"></i></div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endforeach
    @endif
    <div class="row">
        <div class="col-6">
            <div class="form-group">
                <select class="form-control" id="daySelect">
                    <option value="monday">Monday</option>
                    <option value="tuesday">Tuesday</option>
                    <option value="wednesday">Wednesday</option>
                    <option value="thursday">Thursday</option>
                    <option value="friday">Friday</option>
                    <option value="saturday">Saturday</option>
                    <option value="sunday">Sunday</option>
                </select>
            </div>
        </div>
        <div class="col-6">
            <div class="input-group date" id="time_slots" data-target-input="nearest">
                <input type="text" class="form-control datetimepicker-input"
                       data-target="#time_slots"/>
                <div class="input-group-append" data-target="#time_slots"
                     data-toggle="datetimepicker">
                    <div class="input-group-text"><i class="fa fa-clock"></i></div>
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
        $('#time_slots').datetimepicker({icons: {time: 'far fa-clock'}, format: 'LT'});
        $('#addSlot').on('click', function (e) {
            let slot = $("input[data-target='#time_slots']").val();
            if (slot.length < 1) {
                return;
            }
            let day = $("#daySelect").find(':selected').val();
        @this.addSlot(day, slot);
            $("input[data-target='#time_slots']").val('');
        })
    </script>
@endpush
