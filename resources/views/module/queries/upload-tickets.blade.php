@php
    $step_data = $query->getStepResponse(\App\Models\QueryResponse::ticketsAndVisa);
@endphp
<div class="card card-primary">
    <div class="card-header">
        <h4 class="card-title">Uploaded tickets and visa</h4>
    </div>
    <div class="card-body">
        <h5> Ticket Files:</h5>
        @if(!empty($step_data['tickets']))
            <div class="row">
                @foreach($step_data['tickets'] as $response)
                    <div class="col-md-3 col-sm-6 col-12">
                        <a class="link-unstyled" href="{{ $response }}" target="_blank">
                            <div class="info-box">
                                <span class="info-box-icon bg-warning"><i class="far fa-copy"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text"> Ticket file {{$loop->index+1}}</span>
                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        @endif
        <hr>
        <h5> Visa Files:</h5>
        @if(!empty($step_data['visa']))
            <div class="row">
                @foreach($step_data['visa'] as $response)
                    <div class="col-md-3 col-sm-6 col-12">
                        <a class="link-unstyled" href="{{ $response }}" target="_blank">
                            <div class="info-box">
                                <span class="info-box-icon bg-warning"><i class="far fa-copy"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text"> Visa file {{$loop->index+1}}</span>
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
        <a href="{{ route('query.show', ['query' => $query->id, 'tab' => 'payment-required']) }}" class="btn btn-info">Previous</a>
        <a href="{{ route('query.show', ['query' => $query->id, 'tab' => 'coordinator']) }}"
           class="btn btn-dark">Next</a>
    </div>
</div>
