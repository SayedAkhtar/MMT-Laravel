@php
    $step_data = $query->getStepResponse(\App\Models\QueryResponse::payment);
    $completed = $query->is_confirmed || ($query->current_step > 4);
@endphp
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
            <form action="{{ route('query.update', ['query' => $query->id]) }}" method="post">
                @csrf
                @method('PUT')
                <div class="form-check">
                    <input type="hidden" name="set_payment_type" value="true"/>
                    <input class="form-check-input" type="checkbox" name="payment_required"
                           @if($query->payment_required) checked @endif @if ($completed) disabled @endif />
                    <label class="form-check-label">Is Payment required</label>
                </div>
                <button class="btn btn-warning" @if ($completed) disabled @endif>Submit</button>
            </form>
        </div>
    </div>
</div>

<div class="row mb-4">
    <div class="col-12 d-flex justify-content-between">
        <a href="{{ route('query.show', ['query' => $query->id, 'tab' => 'upload-medical-visa']) }}"
           class="btn btn-info">Previous</a>
        <a href="{{ route('query.show', ['query' => $query->id, 'tab' => 'upload-ticket']) }}"
           class="btn btn-dark">Next</a>
        {{--            <button class="btn btn-success" type="submit" form="doctorResponseForm"> Submit & Continue</button>--}}
        {{--        @endif--}}
    </div>
</div>
