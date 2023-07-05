@php
    $coordinator = \App\Models\User::where('user_type', \App\Models\User::TYPE_HCF)->select('id', 'name')->get();
    $hospitals = \App\Models\Accommodation::all();
@endphp
<form action="{{ route('query.confirm') }}" method="post" id="confirmedQueryForm">
    @csrf
    <input type="hidden" name="query_id" value="{{ $query->id }}">
    <div class="row">

        <div class="col-md-6">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Coordinator Info</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label> Name </label>
                        <select class="form-control" id="coordinator_id"
                                name="coordinator_id">
                            @if(!empty($coordinator))
                                @foreach($coordinator as $data)
                                    <option value="{{ $data->id }}">
                                        {{ $data->name }}
                                    </option>
                                @endforeach
                            @else
                                <option value="">Select Option</option>
                            @endif
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="inputName">Name</label>
                        <input type="text" class="form-control" readonly>
                    </div>
                    <div class="form-group">
                        <label for="inputDescription">Email</label>
                        <input type="text" id="inputName" class="form-control" readonly>
                    </div>
                    <div class="form-group">
                        <label for="inputDescription">Phone Number</label>
                        <input type="text" id="inputName" class="form-control" readonly>
                    </div>
                    <div class="form-group">
                        <label for="inputDescription">Languages Spoken</label>
                        <input type="text" id="inputName" class="form-control" readonly>
                    </div>
                </div>
                <!-- /.card-body -->
            </div>
        </div>
        <div class="col-md-6">
            <div class="card card-secondary">
                <div class="card-header">
                    <h3 class="card-title">Hotel Info</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label for="inputName">Search Accommodations</label>
                        <select name="accommodation_id" id="accommodation_id" class="form-control">
                            @if(!empty($hospitals))
                                @foreach($hospitals as $data)
                                    <option value="{{ $data->id }}">
                                        {{ $data->name }}
                                    </option>
                                @endforeach
                            @else
                                <option value="">Select Option</option>
                            @endif
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="inputEstimatedBudget">Name</label>
                        <input type="text" class="form-control" readonly>
                    </div>
                    <div class="form-group">
                        <label for="inputEstimatedBudget">Address</label>
                        <input type="text" class="form-control" readonly>
                    </div>
                    <div class="form-group">
                        <label for="inputEstimatedBudget">Type</label>
                        <input type="text" class="form-control" readonly>
                    </div>
                </div>
                <!-- /.card-body -->
            </div>
            <div class="card card-secondary">
                <div class="card-header">
                    <h3 class="card-title">Cab Details</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label for="inputEstimatedBudget">Name</label>
                        <input type="text" name="name" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="inputEstimatedBudget">Car Number</label>
                        <input type="text" class="form-control" name="car_number">
                    </div>
                    <div class="form-group">
                        <label for="inputEstimatedBudget">Car Type</label>
                        <input type="text" class="form-control" name="car_type">
                    </div>
                </div>
                <!-- /.card-body -->
            </div>

        </div>
    </div>
</form>
<div class="row mb-4">
    <div class="col-12 d-flex justify-content-between">
        <a href="{{ route('query.show', ['query' => $query->id, 'tab' => 'upload-ticket']) }}" class="btn btn-primary">Previous</a>
        <button class="btn btn-success" form="confirmedQueryForm" type="submit">Submit & Confirm Query</button>
    </div>
</div>

@push('plugin-scripts')
    <script src="{{ asset('plugins/select2/js/select2.full.min.js')}}"></script>
@endpush
