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
            <h3 class="card-title">Edit a Treatment</h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
            <form action="{{ route('treatments.update', ['treatment' => $treatment->id]) }}" method="post"
                  enctype="multipart/form-data">
                @csrf
                @method('put')
                <div class="row">
                    <div class="col-sm-6">
                        <!-- text input -->
                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" class="form-control" placeholder="Enter name" name="name"
                                   value="{{ $treatment->name }}">
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Price</label>
                            <input type="number" class="form-control" placeholder="Enter Min price" name="min_price"
                                   value="{{ $treatment->min_price }}">
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Price</label>
                            <input type="number" class="form-control" placeholder="Enter Max price" name="max_price"
                                   value="{{ $treatment->max_price }}">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <!-- text input -->
                        <div class="form-group">
                            <div>
                                <label for="exampleInputFile">Treatment Logo</label>
                                @if(!empty($treatment->logo))
                                    <div class="image-uploader-preview d-flex">
                                        {{-- {{ Storage::get($treatment->logo) }} --}}
                                        <img src="{{ Storage::url($treatment->logo) }}" alt=""
                                                 class="image-uploader-preview-img mr-2">
                                    </div>
                                @endif
                                <div class="input-group">
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" id="exampleInputFile" name="logo">
                                        <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Estimated Days of Stay in Hospital</label>
                            <input type="text" class="form-control"
                                   placeholder="Enter Estimated Days of Stay in hospital"
                                   name="days_required" value="{{ $treatment->days_required }}">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <!-- text input -->
                        <div class="form-group">
                            <label>Treatment Success rate</label>
                            <input type="text" max=100 class="form-control"
                                   placeholder="Enter success rate (percentage)"
                                   name="success_rate" value="{{ $treatment->success_rate }}">
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>EDT in India Outside hospital</label>
                            <input type="text" class="form-control"
                                   placeholder="Enter Estimated Days of Stay in india outside hospital"
                                   name="recovery_time" value="{{ $treatment->recovery_time }}">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <x-multi-select-search label="Hospitals" name="hospitals" table="hospitals"
                                                   multiple="true" :selectedOptions="$treatment->hospitals"/>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <x-multi-select-search label="Doctors" name="doctors" table="doctors" multiple="true"
                                                   :selectedOptions="$treatment->doctors"/>
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
                            <x-multi-select-search label="Specializations" name="specializations"
                                                   table="specializations"
                                                   multiple=true :selectedOptions="$treatment->specializations"/>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <!-- text input -->
                        <div class="form-group">
                            <label>Whats Covered</label>
                            <textarea class="form-control" name="covered" id="" cols="30"
                                      rows="10">{{ $treatment->covered }}</textarea>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <!-- text input -->
                        <div class="form-group">
                            <label>Whats Not Covered</label>
                            <textarea class="form-control" name="not_covered" id="" cols="30"
                                      rows="10">{{ $treatment->not_covered }}</textarea>
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
