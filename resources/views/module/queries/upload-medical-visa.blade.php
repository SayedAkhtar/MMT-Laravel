@php
    $step_data = $query->getStepResponse(3);
    $payment = $query->is_confirmed || $query->current_step > 4;
@endphp
<div class="card card-primary">
    <div class="card-header">
        <h4 class="card-title">Uploaded documents for Visa application</h4>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-12">
                <div class="row">
                    <div class="col">
                        <h6>Preferred Country :</h6>
                        <h5>{{ $step_data['country'] ?? 'No Country Preferred' }}</h5>
                    </div>
                    <div class="col">
                        <h6>Preferred City : </h6>
                        <h5>{{ $step_data['city'] ?? 'No City Preferred' }}</h5>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            @if (!empty($step_data['passport']))
                <div class="col-md-3 col-sm-6 col-12">
                    <a class="link-unstyled" href="{{ $step_data['passport'] }}" target="_blank">
                        <div class="info-box">
                            <span class="info-box-icon bg-warning"><i class="far fa-copy"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">Patient Passport</span>
                            </div>
                        </div>
                    </a>
                </div>
            @endif
            @if (!empty($step_data['attendant_passport']))
                @foreach ($step_data['attendant_passport'] as $link)
                    <div class="col-md-3 col-sm-6 col-12">
                        <a class="link-unstyled" href="{{ $link }}" target="_blank">
                            <div class="info-box">
                                <span class="info-box-icon bg-warning"><i class="far fa-copy"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text"> {{ $loop->index + 1 }}. Attendants Passport</span>
                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach
            @endif
            <div class="form-group ">
                <div class="row">

                    @if (!empty($step_data['vil']))
                        @foreach ($step_data['vil'] as $item)
                            <div class="col-md-3 col-sm-6 col-12">
                                <span class="info-box-text">Uploaded Visa Invitation Letter :- </span>
                                <a class="link-unstyled" href="{{ $item }}" target="_blank">
                                    <div class="info-box">
                                        <span class="info-box-icon bg-warning"><i class="far fa-copy"></i></span>
                                        <div class="info-box-content">
                                            <span class="info-box-text"> Visa Invitation Letter</span>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        @endforeach
                    @else
                        <div class="col-4">
                            <form method="POST" action="{{ route('update-vil', ['id' => $query->id]) }}"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="input-group">
                                    <span class="info-box-text">Upload Visa Invitation Letter:- </span>
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" id="exampleInputFile"
                                            name="vil[]" required multiple>
                                        <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                                    </div>
                                    <div class="input-group-append">
                                        <button class="input-group-text" type="submit">Upload</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    @endif
                </div>


            </div>
            @if (!empty($step_data))
                <div class="form-group">
                    <form action="{{ route('query.update', ['query' => $query->id]) }}" method="post">
                        @csrf
                        @method('PUT')
                        <div class="form-check">
                            <input type="hidden" name="set_payment_type" value="true" />
                            <input class="form-check-input" type="checkbox" name="payment_required"
                                @if ($query->payment_required) checked disabled @endif />
                            <label class="form-check-label">Is Payment required</label>
                        </div>
                        @if (!$query->payment_required)
                            <button class="btn btn-warning">Submit</button>
                        @endif
                    </form>
                </div>
            @endif
        </div>
    </div>
</div>

<div class="row mb-4">
    <div class="col-12 d-flex justify-content-between">
        <a href="{{ route('query.show', ['query' => $query->id, 'tab' => 'doctor-review']) }}"
            class="btn btn-info">Previous</a>
        @if (!empty($step_data))
            @if ($query->current_step == \App\Models\QueryResponse::documentForVisa)
                <form action="{{ route('query.update-step', ['id' => $query->id]) }}" method="post">
                    @csrf
                    <button class="btn btn-success" type="submit"> Confirm and Proceed to Next Step</button>
                </form>
            @else
                <a href="{{ route('query.show', ['query' => $query->id, 'tab' => 'payment-required']) }}"
                    class="btn btn-dark">Next</a>
            @endif
        @endif
        {{-- <a href="{{ route('query.show', ['query' => $query->id, 'tab' => 'payment-required']) }}" class="btn btn-dark">Next</a> --}}
    </div>
</div>
