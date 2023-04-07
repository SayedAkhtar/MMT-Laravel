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
            <h3 class="card-title">Add a Specialization</h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
            <form action="{{ route('specializations.store') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-sm-6">
                        <!-- text input -->
                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" class="form-control" placeholder="Enter name" name="name">
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <!-- text input -->
                        <div class="form-group">
                            <x-form-image-input label="Logo" name="logo"/>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <div class="form-group">
                            <div class="custom-control custom-switch">
                                <input type="checkbox" class="custom-control-input" id="customSwitch1" name="is_active">
                                <label class="custom-control-label" for="customSwitch1">Specializations Active
                                    Status</label>
                            </div>
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
        });
        $('.select2bs4').select2({
            theme: 'bootstrap4'
        });

    </script>
@endpush
