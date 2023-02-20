<div class="card card-primary">
    <div class="card-header">
        <h4 class="card-title">Uploaded documents for Visa application</h4>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-12">
                <div class="row">
                    <div class="col">
                        <h4>Preferred Country :</h4>
                        <p>{{ $query->activeQuery->country?? 'No Country Preferred' }}</p>
                    </div>
                    <div class="col">
                        <h4>Preferred City : </h4>
                        <p>{{ $query->activeQuery->state?? 'No State Preferred' }}</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 col-lg-6 col-xl-4">
                <div class="card mb-2 bg-gradient-dark">
                    <img class="card-img-top" src="{{ asset('/assets/img/team-1.jpg')}}" alt="Dist Photo 1">
                    <div class="card-footer">
                        <div class="row">
                            <div class="col">
                                <h5 class="card-title text-primary text-white">Passport</h5>
                                <p class="card-text text-white pb-2 pt-1">Passport number: 97867898788908</p>
                            </div>
                            <div class="col-2">
                                <button class="btn btn-success"><i class="fas fa-download"></i></button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row mb-4">
    <div class="col-12 d-flex justify-content-between">
        <a href="{{ route('query.show', ['query' => $query->id, 'tab' => 'doctor-review']) }}" class="btn btn-info">Previous</a>
        <a href="{{ route('query.show', ['query' => $query->id, 'tab' => 'payment-required']) }}" class="btn btn-dark">Next</a>
    </div>
</div>