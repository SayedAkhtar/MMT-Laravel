@php
    $step_data = $query->getStepResponse(2);
@endphp
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
            <form action="{{ route('query.store') }}" method="post" id="doctorResponseForm">
                @csrf
                <input type="hidden" name="query_id" value="{{ $query->id }}">
                <input type="hidden" name="type" value="{{ \App\Models\Query::TYPE_QUERY }}">
                <input type="hidden" name="current_step" value="{{ \App\Models\QueryResponse::doctorResponse }}">
                <textarea id="inputDescription" class="form-control" rows="4"
                          name="response[doctor]">{!! $step_data['doctor'] ?? '' !!}</textarea>
            </form>
        </div>
        @if(!empty($step_data['patient']))
            <div class="row">
                @foreach($step_data['patient'] as $response)
                    <div class="col-md-3 col-sm-6 col-12">
                        <a class="link-unstyled" href="{{ $response }}" target="_blank">
                            <div class="info-box">
                                <span class="info-box-icon bg-warning"><i class="far fa-copy"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text"> Uploaded file {{$loop->index+1}}</span>
                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>

<div class="row mb-4">
    <div class="col-12 d-flex justify-content-between">
        <a href="{{ route('query.show', ['query' => $query->id, 'tab' => 'details']) }}"
           class="btn btn-info">Previous</a>
        {{--        @if(!empty($step_data['doctor']))--}}
        {{--            <a href="{{ route('query.show', ['query' => $query->id, 'tab' => 'upload-medical-visa']) }}"--}}
        {{--               class="btn btn-dark">Next</a>--}}
        {{--        @else--}}
        <button class="btn btn-success" type="submit" form="doctorResponseForm"> Submit & Continue</button>
        {{--        @endif--}}
    </div>
</div>
