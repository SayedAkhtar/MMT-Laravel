<div class="card card-secondary">
    <div class="card-header">
        <h3 class="card-title">Doctors Review</h3>
        <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                <i class="fas fa-minus"></i>
            </button>
        </div>
    </div>
    <div class="card-body">
        <div class="form-group">
            <label for="inputDescription">Review</label>
            <form action="{{ route('activeQuery.store') }}" method="post" id="doctorResponseForm">
                @csrf
                <input type="hidden" name="query_id" value="{{ $query->id }}">
                <textarea id="inputDescription" class="form-control" rows="4"
                          name="doctor_response">{!! $query->activeQuery?->doctor_response !!}</textarea>
            </form>
        </div>
        @if(!empty($query->activeQuery?->patient_response))
            <div class="col-md-4">
                <img class="card-img-top"
                     src="{{ \Illuminate\Support\Facades\Storage::url($query->activeQuery?->patient_response) }}"
                     alt="Dist Photo 2">
            </div>
        @endif
    </div>
</div>

<div class="row mb-4">
    <div class="col-12 d-flex justify-content-between">
        <a href="{{ route('query.show', ['query' => $query->id, 'tab' => 'details']) }}"
           class="btn btn-info">Previous</a>
        @if(!empty($query->activeQuery?->doctor_response))
            <a href="{{ route('query.show', ['query' => $query->id, 'tab' => 'upload-medical-visa']) }}"
               class="btn btn-dark">Next</a>
        @else
            <button class="btn btn-success" type="submit" form="doctorResponseForm"> Submit & Continue</button>
        @endif
    </div>
</div>
