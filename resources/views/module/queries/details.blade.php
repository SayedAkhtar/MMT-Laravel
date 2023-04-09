<div class="row">
    <div class="col-md-6">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Patient Info</h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                </div>
            </div>
            <div class="card-body">
                <div class="form-group">
                    <label for="inputName">Specialization</label>
                    <input type="text" id="inputName" class="form-control" value="{{ $query->specialization->name }}"
                           readonly>
                </div>
                <div class="form-group">
                    <label for="inputDescription">Name</label>
                    <input type="text" id="inputName" class="form-control" value="{{ $query->patient->name }}" readonly>
                </div>
                <div class="form-group">
                    <label for="inputDescription">Email</label>
                    <input type="text" id="inputName" class="form-control" value="{{ $query->patient->email }}"
                           readonly>
                </div>
                <div class="form-group">
                    <label for="inputDescription">Phone Number</label>
                    <input type="text" id="inputName" class="form-control" value="{{ $query->patient->phone }}"
                           readonly>
                </div>
                <div class="form-group">
                    <label for="inputDescription">Gender</label>
                    <input type="text" id="inputName" class="form-control" value="{{ $query->patient->gender }}"
                           readonly>
                </div>
                <div class="form-group">
                    <label for="inputDescription">Country</label>
                    <input type="text" id="inputName" class="form-control" value="{{ $query->patient->country }}"
                           readonly>
                </div>
                <div class="form-group">
                    <label for="inputDescription">Date Of Birth</label>
                    <input type="text" id="inputName" class="form-control"
                           value="{{ date('d-m-Y', strtotime($query->patient->dob)) }}" readonly>
                </div>
            </div>
            <!-- /.card-body -->
        </div>
        <div class="card card-info">
            <div class="card-header">
                <h3 class="card-title">Files</h3>

                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                </div>
            </div>
            <div class="card-body p-0">
                <table class="table">
                    <thead>
                    <tr>
                        <th>File Name</th>
                        <th>File Size</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>

                    <tr>
                        <td>Functional-requirements.docx</td>
                        <td>49.8005 kb</td>
                        <td class="text-right py-0 align-middle">
                            <div class="btn-group btn-group-sm">
                                <a href="#" class="btn btn-info"><i class="fas fa-eye"></i></a>
                                <a href="#" class="btn btn-danger"><i class="fas fa-trash"></i></a>
                            </div>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <!-- /.card-body -->
        </div>
    </div>
    <div class="col-md-6">
        <div class="card card-secondary">
            <div class="card-header">
                <h3 class="card-title">Doctor Info</h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                </div>
            </div>
            <div class="card-body">
                @if(!empty($query->doctor_id))
                    <div class="form-group">
                        <label for="inputEstimatedBudget">Name</label>
                        <input type="text" class="form-control" value="{{ $query->doctor->name }}" readonly>
                    </div>
                    <div class="form-group">
                        <label for="inputEstimatedBudget">Designation</label>
                        <input type="text" class="form-control" value="{{ $query->doctor->doctor->designation->name }}"
                               readonly>
                    </div>
                    <div class="form-group">
                        <label for="inputEstimatedBudget">Qualification</label>
                        <input type="text" class="form-control"
                               value="{{ $query->doctor->doctor->qualification->name }}" readonly>
                    </div>
                    <div class="form-group">
                        <label for="inputEstimatedBudget">Specialization</label>
                        <input type="text" class="form-control"
                               value="{{ $query->doctor->doctor->specializations->pluck('name')->join(',') }}"
                               readonly>
                    </div>
                    <div class="form-group">
                        <label for="inputEstimatedBudget">Treatment</label>
                        <input type="text" class="form-control"
                               value="{{ $query->doctor->doctor->doctorTreatments->pluck('name')->join(',') }}"
                               readonly>
                    </div>
                @else
                    <p>No doctor preference</p>
                @endif
            </div>
            <!-- /.card-body -->
        </div>

        <div class="card card-secondary">
            <div class="card-header">
                <h3 class="card-title">Hospital Info</h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                </div>
            </div>
            <div class="card-body">
                @if(!empty($query->hospital_id))
                    <div class="form-group">
                        <label for="inputEstimatedBudget">Name</label>
                        <input type="text" class="form-control" value="{{ $query->hospital->name }}" readonly>
                    </div>
                    <div class="form-group">
                        <label for="inputEstimatedBudget">Address</label>
                        <input type="text" class="form-control" value="{!! $query->hospital->address !!}" readonly>
                    </div>
                    <div class="form-group">
                        <label for="inputEstimatedBudget">Treatments</label>
                        <input type="text" class="form-control"
                               value="{{ $query->hospital->treatments->pluck('name')->join(',') }}" readonly>
                    </div>
                    <div class="form-group">
                        <label for="inputEstimatedBudget">Accreditations</label>
                        {{--                        <input type="text" class="form-control"--}}
                        {{--                               value="{{ $query->hospital?->hospital->pluck('name')->join(',') }}"--}}
                        {{--                               readonly>--}}
                    </div>
                @else
                    <p>No Hospital preference</p>
                @endif
            </div>
            <!-- /.card-body -->
        </div>
    </div>
</div>
<div class="row mb-4">
    <div class="col-12">
        <a href="{{ route('query.show', ['query' => $query->id, 'tab' => 'doctor-review']) }}" class="btn btn-primary">Next</a>
    </div>
</div>
