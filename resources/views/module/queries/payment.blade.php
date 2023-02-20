<div class="card card-secondary">
    <div class="card-header">
        <h3 class="card-title">Payment Status</h3>
        <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                <i class="fas fa-minus"></i>
            </button>
        </div>
    </div>
    <div class="card-body">
        <div class="form-group">
            <form action="">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox">
                    <label class="form-check-label">Is Payment required</label>
                </div>
                <button class="btn btn-warning">Submit</button>
            </form>
        </div>
    </div>
</div>

<div class="row mb-4">
    <div class="col-12 d-flex justify-content-between">
        <a href="{{ route('query.show', ['query' => $query->id, 'tab' => 'upload-medical-visa']) }}" class="btn btn-info">Previous</a>
        @if(!empty($query->activeQuery?->doctor_response))
            <a href="{{ route('query.show', ['query' => $query->id, 'tab' => 'upload-ticket']) }}" class="btn btn-dark">Next</a>
        @else
            <button class="btn btn-success" type="submit" form="doctorResponseForm"> Submit & Continue</button>
        @endif
    </div>
</div>