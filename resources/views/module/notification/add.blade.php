@extends('layouts.user_type.auth')
@push('plugin-styles')
    <link rel="stylesheet" href="{{ asset("plugins/daterangepicker/daterangepicker.css")}}">
    <link rel="stylesheet" href="{{ asset("plugins/select2/css/select2.min.css")}}">
    <link rel="stylesheet" href="{{ asset("plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css")}}">
    <link rel="stylesheet" href="{{ asset("plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css")}}">
@endpush
@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3 class="card-title">Custom Notification</h3>
            <a href="{{ route('notification.index') }}" class="btn btn-success">Show All Sent Notifications</a>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
            <form action="{{ route('notification.store') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-sm-6">
                        <!-- text input -->
                        <div class="form-group">
                            <label>Title</label>
                            <input type="text" class="form-control" placeholder="Notification Title" name="title" required>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <!-- text input -->
                        <div class="form-group">
                            <label>Body</label>
                            <input type="text" class="form-control" placeholder="Notification Body" name="body" required>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <!-- text input -->
                        <div class="form-group">
                            <label>Promotional Url (Optional)</label>
                            <input type="text" class="form-control" placeholder="Valid Url" name="url" />
                        </div>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-sm-12">
                        <div class="form-group">
                            <div class="custom-control custom-switch">
                                <input type="checkbox" class="custom-control-input" id="customSwitch1" name="all_users">
                                <label class="custom-control-label" for="customSwitch1">Send To All User</label>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <label for="users">Select Users:- </label>
                        <select class="form-select select2 select2bs4" name="users[]" id="users" multiple>
                            @foreach ($users as $item)
                                <option value="{{ $item->id }}"> {{$item->name}} </option>
                            @endforeach
                        </select>
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
