<form action="{{ route('confirmedQuery.store') }}" method="post" id="confirmedQueryForm">
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
            @livewire('assign-cordinator-to-query', ['query' => $query])
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
            @livewire('assign-hotel-to-query', ['query' => $query])
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