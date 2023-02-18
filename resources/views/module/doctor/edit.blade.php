@extends('layouts.user_type.auth')
@push('plugin-styles')
    <link rel="stylesheet" href="{{ asset("plugins/daterangepicker/daterangepicker.css")}}">
    <link rel="stylesheet" href="{{ asset("plugins/select2/css/select2.min.css")}}">
    <link rel="stylesheet" href="{{ asset("plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css")}}">
    <link rel="stylesheet" href="{{ asset("plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css")}}">
@endpush
@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Edit </h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
            <form action="{{ route('doctor.store') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-sm-6">
                        <!-- text input -->
                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" class="form-control" placeholder="Enter name" name="name" value="{{ $doctor->user->name }}">
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Email</label>
                            <input type="email" class="form-control" placeholder="Enter email" name="email" value="{{ $doctor->user->email }}">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <!-- text input -->
                        <div class="form-group">
                            <label>Password</label>
                            <input type="text" class="form-control" placeholder="Enter name" name="password">
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Phone Number</label>
                            <input type="phone" class="form-control" placeholder="Enter phone with country code" name="phone" value="{{ $doctor->user->phone }}">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <!-- text input -->
                        <div class="form-group">
                            <label for="exampleInputFile">File input</label>
                            <div class="input-group">
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="exampleInputFile" name="image">
                                    <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                                </div>
                                <div class="input-group-append">
                                    <span class="input-group-text">Upload</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Gender</label>
                            <select class="form-control" name="gender">
                                <option>Select Option</option>
                                <option value="male" {{ $doctor->user->gender == 'male' ? 'selected' : '' }}>Male</option>
                                <option value="female" {{ $doctor->user->gender == 'female' ? 'selected': '' }}>Female</option>
                                <option value="other" {{ $doctor->user->gender == 'other' ? 'selected' : '' }}>Other</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <!-- text input -->
                        <div class="form-group">
                            <label>Country</label>
                            <input type="text" class="form-control" placeholder="Enter name" name="country" value="{{ $doctor->user->country }}">
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Date of birth</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                                </div>
                                <input type="text" class="form-control" data-inputmask-alias="datetime"
                                       data-inputmask-inputformat="mm/dd/yyyy" data-mask="" inputmode="numeric" name="dob" value="{{ $doctor->user->dob }}">
                            </div>
                            <!-- /.input group -->
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <!-- text input -->
                        <div class="form-group">
                            <label>Designation</label>
                            <select class="form-control select2bs4" style="width: 100%;" name="designation_id">
                                <option selected="selected">Alabama</option>
                                <option value="1" {{ $doctor->designation_id == 1 ? 'selected' :'' }}>Alaska</option>
                                <option {{ $doctor->designation_id == 2 ? 'selected' :'' }}>California</option>
                                <option {{ $doctor->designation_id == 3 ? 'selected' :'' }}>Delaware</option>
                                <option {{ $doctor->designation_id == 4 ? 'selected' :'' }}>Tennessee</option>
                                <option {{ $doctor->designation_id == 5 ? 'selected' :'' }}>Texas</option>
                                <option {{ $doctor->designation_id == 6 ? 'selected' :'' }}>Washington</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Qualification</label>
                            <select class="form-control select2bs4" style="width: 100%;" name="qualification_id">
                                <option selected="selected">Alabama</option>
                                <option value="1" {{ $doctor->designation_id == 2 ? 'selected' :'' }}>Alaska</option>
                                <option>California</option>
                                <option>Delaware</option>
                                <option>Tennessee</option>
                                <option>Texas</option>
                                <option>Washington</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <!-- text input -->
                        <div class="form-group">
                            <label>Awards</label>
                            <input type="text" class="form-control" placeholder="Enter name" name="awards" value="{{ $doctor->awards }}">
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Start of service</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                                </div>
                                <input type="text" class="form-control" data-inputmask-alias="datetime"
                                       data-inputmask-inputformat="mm/dd/yyyy" data-mask="" inputmode="numeric" name="start_of_service" value="{{ $doctor->start_of_service }}">
                            </div>
                            <!-- /.input group -->
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <!-- text input -->
                        <div class="form-group">
                            <label>Time Slots:</label>
                            <div class="input-group date" id="time_slots" data-target-input="nearest">
                                <input type="text" name="time_slots" class="form-control datetimepicker-input" data-target="#time_slots" value="{{ $doctor->time_slots }}" />
                                <div class="input-group-append" data-target="#reservationdatetime" data-toggle="datetimepicker">
                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <!-- text input -->
                        <div class="form-group">
                            <label>Description</label>
                            <textarea class="form-control" rows="3" placeholder="Enter ..." name="description">{{ $doctor->description }}</textarea>
                        </div>
                    </div>
                </div>
                <button class="btn btn-success btn-xl">Submit</button>
            </form>
        </div>
        <!-- /.card-body -->
        <div class="card-footer">

        </div>
    </div>
@endsection

@push('plugin-scripts')
    <script src="{{ asset("plugins/select2/js/select2.full.min.js")}}"></script>
    <script src="{{ asset("plugins/bs-custom-file-input/bs-custom-file-input.min.js")}}"></script>
    <script src="{{ asset("plugins/moment/moment.min.js")}}"></script>
    <script src="{{ asset("plugins/inputmask/jquery.inputmask.min.js") }}"></script>
    <script src="{{ asset("plugins/daterangepicker/daterangepicker.js") }}"></script>
    <script src="{{ asset("plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js") }}"></script>
@endpush

@push('scripts')
    <script>
        $(function () {
            bsCustomFileInput.init();
            $('[data-mask]').inputmask();
            $('#reservationdatetime').datetimepicker({ icons: { time: 'far fa-clock' } });
        });
        $('.select2bs4').select2({
            theme: 'bootstrap4'
        })
    </script>
@endpush