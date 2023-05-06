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
            <h3 class="card-title">Edit Consultation</h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
            <form action=""
                  method="post"
                  enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-sm-6">
                        <!-- text input -->
                        <div class="form-group">
                            <label>Date and time:</label>
                            <div class="input-group date" id="reservationdatetime" data-target-input="nearest">
                                <input type="text" class="form-control datetimepicker-input"
                                       data-target="#reservationdatetime" name="scheduled_at"/>
                                <div class="input-group-append" data-target="#reservationdatetime"
                                     data-toggle="datetimepicker">
                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <button class="btn btn-success btn-xl">Submit</button>
            </form>
        </div>
        <!-- /.card-body -->
        <div class="card-footer">
            <form action=""
                  method="post"
                  enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <input type="hidden" name="status" value="active"/>
                <button class="btn btn-info btn-xl">Make Call Active</button>
            </form>
            <form action=""
                  method="post"
                  enctype="multipart/form-data" class="my-2">
                @csrf
                @method('PUT')
                <input type="hidden" name="status" value="complete"/>
                <button class="btn btn-danger btn-xl">Mark Call As Completed</button>
            </form>
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
        console.log(new Date('30-04-2023T20:04:56'));
        $('#reservationdatetime').datetimepicker(
            {
                icons: {time: 'far fa-clock'},
                defaultDate: new Date('{{ $consultation->scheduled_at }}'),
            }
        );
    </script>
@endpush
