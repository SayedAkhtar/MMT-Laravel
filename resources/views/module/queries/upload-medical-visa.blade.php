@php
    $step_data = $query->getStepResponse(3);
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
                        <h5>{{ $step_data['country']?? 'No Country Preferred' }}</h5>
                    </div>
                    <div class="col">
                        <h6>Preferred City : </h6>
                        <h5>{{ $step_data['city']?? 'No City Preferred' }}</h5>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            @if(!empty($step_data['passport']))
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
            @if(!empty($step_data['attendant_passport']))
                @foreach($step_data['attendant_passport'] as $link)
                    <div class="col-md-3 col-sm-6 col-12">
                        <a class="link-unstyled" href="{{ $link }}" target="_blank">
                            <div class="info-box">
                                <span class="info-box-icon bg-warning"><i class="far fa-copy"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text"> {{$loop->index+1}}. Attendants Passport</span>
                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach
            @endif
        </div>
    </div>
</div>

<div class="row mb-4">
    <div class="col-12 d-flex justify-content-between">
        <a href="{{ route('query.show', ['query' => $query->id, 'tab' => 'doctor-review']) }}" class="btn btn-info">Previous</a>
        <a href="{{ route('query.show', ['query' => $query->id, 'tab' => 'payment-required']) }}" class="btn btn-dark">Next</a>
    </div>
</div>
