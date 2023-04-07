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
            <h3 class="card-title">Add a Treatment</h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
            <form action="{{ route('treatments.store') }}" method="post" enctype="multipart/form-data">
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
                        <div class="form-group">
                            <label>Price</label>
                            <input type="number" class="form-control" placeholder="Enter price" name="price">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <!-- text input -->
                        <div class="form-group">
                            <x-form-image-input label="Logo" name="images" multiple="true"/>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>ETD in Hospital</label>
                            <input type="number" class="form-control" placeholder="Enter ETD in hospital"
                                   name="days_required">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <!-- text input -->
                        <div class="form-group">
                            <label>Treatment Success rate</label>
                            <input type="number" max=100 class="form-control"
                                   placeholder="Enter success rate (percentage)"
                                   name="success_rate">
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>EDT in India Outside hospital</label>
                            <input type="number" class="form-control" placeholder="Enter ETD in india outside hospital"
                                   name="recovery_time">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <x-multi-select-search label="Hospitals" name="hospitals" table="hospitals"
                                                   multiple="true"/>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <x-multi-select-search label="Doctors" name="doctors" table="doctors" multiple="true"/>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Blogs</label>
                            <select class="form-control select2bs4" name="blogs[]" multiple="true">
                                <option>Select Option</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <x-multi-select-search label="Specializations" name="specialization" table="specializations"
                                                   multiple=true/>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <!-- text input -->
                        <div class="form-group">
                            <label>Whats Covered</label>
                            <textarea class="form-control" name="covered" id="" cols="30" rows="10"></textarea>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <!-- text input -->
                        <div class="form-group">
                            <label>Whats Not Covered</label>
                            <textarea class="form-control" name="not_covered" id="" cols="30" rows="10"></textarea>
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
        $(document).ready(function () {
            $('.select2bs4').select2({
                theme: 'bootstrap4'
            });
        });
    </script>
@endpush
