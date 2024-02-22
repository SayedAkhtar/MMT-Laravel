<div class="card">
    <div class="card-body">
        <form action="#" wire:submit="save">
            {{-- <div class="row">
            <div class="col-sm-6">
                <!-- text input -->
                <div class="form-group">
                    <label>Generate Links For Users</label>
                    <select class="form-control" wire:model="userType" required>
                        <option value="">Select User</option>
                        <option value="4">Doctor</option>
                        <option value="3">MMT HCF</option>
                        <option value="5">User</option>
                    </select>
                </div>
            </div>
        </div>
        <button class="btn btn-success btn-xl" type="save">Submit</button> --}}
            @forelse ($links as $user_id => $link)
                <li>Chat Screen Link For <b>
                        @if ($user_id == 3)
                            MMT HCF
                        @elseif ($user_id == 4)
                            Doctor
                        @else
                            User
                        @endif
                    </b>: <a href="javascript:void(0)" onclick="clickToCopy(event)">{{ route('start-consultation', ['id' => $link]) }}</a>
                </li>
            @empty
            @endforelse
        </form>
    </div>
</div>
@push('scripts')
    <script>
        function clickToCopy(event) {
            // Get the text field
            let copyValue = event.target.innerText
            // Copy the text inside the text field
            navigator.clipboard.writeText(copyValue).then(function(){
                alert("Copied the text: "+ copyValue);
            }, function(){
                alert("Copy Error");
            });

            // Alert the copied text
        }
    </script>
@endpush
