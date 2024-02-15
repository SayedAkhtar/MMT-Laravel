@php
    $step_data = $query->getStepResponse(2);
    // if (empty($step_data['document_required'])) {
    //     $step_data['document_required'] = '';
    // }
    // if (empty($step_data['proforma_invoice'])) {
    //     $step_data['proforma_invoice'] = '';
    // }
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
        <form action="{{ route('query.store') }}" method="post" id="doctorResponseForm" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="query_id" value="{{ $query->id }}">
            <input type="hidden" name="type" value="{{ \App\Models\Query::TYPE_QUERY }}">
            <input type="hidden" name="current_step" value="{{ \App\Models\QueryResponse::doctorResponse }}">
            
            @forelse($step_data as $index => $data)
            <div id="accordion">
                <div class="card card-success">
                    <div class="card-header">
                        <h4 class="card-title w-100">
                            <a class="d-block w-100" data-toggle="collapse" href="#collapseThree{{$index+1}}">
                                Doctors Response {{ $index+1 }}
                            </a>
                        </h4>
                    </div>
                    <div id="collapseThree{{$index+1}}" class="collapse" data-parent="#accordion">
                        <div class="card-body">
                            <div class="form-group">
                                <label for="inputDescription">Review</label>
                                <textarea id="inputDescription" class="form-control" rows="4" name="response[{{$loop->index}}][doctor]" disabled>{!! $data['doctor'] ?? '' !!}</textarea>
                                <input type="hidden" name="response[{{$loop->index}}][document_required]" value="{{ $data['document_required'] }}">
                            </div>
                            <div class="row">
                                <div class="col-6">
                                    <a class="link-unstyled" href="{{$data['proforma_invoice']}}" target="_blank">
                                        <div class="info-box">
                                            <span class="info-box-icon bg-warning"><i class="far fa-copy"></i></span>
                                            <div class="info-box-content">
                                                <span class="info-box-text"> Proforma Invoice</span>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
                
            @empty
            @endforelse
            <div class="form-group">
                <label for="inputDescription">Review</label>
                <textarea id="inputDescription" class="form-control" rows="4" name="response[doctor]"></textarea>
            </div>
            <div class="row">
                <div class="col-6">
                    <div class="form-group">
                        <label for="exampleInputFile">Upload Proforma Invoice</label>
                        <div class="input-group">
                            <input type="file" name="response[proforma_invoice]" id="exampleInputFile" accept="application/pdf,image/jpeg,image/png">
                        </div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-group">
                        <label>Documents is required to be uploaded
                            by Patient:</label>
                        <select class="form-control" name="response[document_required]" required>
                            <option value="">Select</option>
                            <option value="1">Yes</option>
                            <option value="0">No</option>
                        </select>
                    </div>
                </div>
            </div>
        </form>
        @if (!empty($step_data['patient']))
            <div class="row">
                @foreach ($step_data['patient'] as $response)
                    <div class="col-md-3 col-sm-6 col-12">
                        <a class="link-unstyled" href="{{ $response }}" target="_blank">
                            <div class="info-box">
                                <span class="info-box-icon bg-warning"><i class="far fa-copy"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text"> Uploaded file {{ $loop->index + 1 }}</span>
                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
    @if (empty($step_data['doctor']))
        <div class="card-footer">
            <button class="btn btn-success" type="submit" form="doctorResponseForm"> Submit Response</button>
        </div>
    @endif
</div>

<div class="row mb-4">
    <div class="col-12 d-flex justify-content-between">
        <a href="{{ route('query.show', ['query' => $query->id, 'tab' => 'details']) }}"
            class="btn btn-info">Previous</a>
            @if ($query->current_step == \App\Models\QueryResponse::doctorResponse)
                <form action="{{ route('query.update-step', ['id' => $query->id]) }}" method="post">
                    @csrf
                    <button class="btn btn-success" type="submit"> Confirm and Proceed to Next Step</button>
                </form>
            @else
                <a href="{{ route('query.show', ['query' => $query->id, 'tab' => 'upload-medical-visa']) }}"
                    class="btn btn-dark">Next</a>
            @endif
    </div>
</div>
