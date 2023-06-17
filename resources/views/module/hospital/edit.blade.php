@extends('layouts.user_type.auth')
@push('plugin-styles')
    <link rel="stylesheet" href="{{ asset('plugins/daterangepicker/daterangepicker.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">
    <link rel="stylesheet" href="https://unpkg.com/dropzone@5/dist/min/dropzone.min.css" type="text/css" />
@endpush
@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Edit a Hospital</h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
            <form action="{{ route('hospitals.update', ['hospital' => $hospital->id]) }}" method="post"
                enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-sm-6">
                        <!-- text input -->
                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" class="form-control" placeholder="Enter name" name="name"
                                value="{{ $hospital->name }}">
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Address</label>
                            <input type="input" class="form-control" placeholder="Enter full address" name="address"
                                value="{{ $hospital->address }}">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <!-- text input -->
                        <div class="form-group">
                            <label> Country</label>
                            <select class="form-control" id="country_id" name="country_id" multiple required>
                                @if (!empty($hospital->countries))
                                    @foreach ($hospital->countries as $country)
                                        <option value="{{ $country->id }}" selected>
                                            {{ $country->name }}
                                        </option>
                                    @endforeach
                                @else
                                    <option value="">Select Option</option>
                                @endif

                            </select>
                            @push('scripts')
                                <script>
                                    $(document).ready(function() {
                                        $('#country_id').select2({
                                            theme: 'bootstrap4',
                                            ajax: {
                                                url: route('ajaxSearch', {
                                                    'table': 'countries'
                                                }),
                                                dataType: 'json',
                                                delay: 500,
                                                data: (params) => {
                                                    return {
                                                        term: params.term,
                                                    }
                                                },
                                                processResults: (data, params) => {
                                                    let results = [];
                                                    if (data.data.length > 0) {
                                                        results = data.data.map(item => {
                                                            return {
                                                                id: item.id,
                                                                text: item.full_name || item.name,
                                                            };
                                                        });
                                                    } else {
                                                        const shouldInsert = false;
                                                        if (params.term != undefined && params.term.length > 2 && shouldInsert) {
                                                            results[0] = {
                                                                id: params.term,
                                                                text: params.term
                                                            }
                                                        }
                                                    }
                                                    return {
                                                        results: results,
                                                    }
                                                },
                                            },
                                        });
                                    });
                                </script>
                            @endpush
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <!-- text input -->
                        <div class="form-group">
                            <label> State</label>
                            <select class="form-control" id="state_id" multiple name="state_id">
                                @if (!empty($hospital->states))
                                    @foreach ($hospital->states as $data)
                                        <option value="{{ $data->id }}" selected>
                                            {{ $data->name }}
                                        </option>
                                    @endforeach
                                @else
                                    <option value="">Select Option</option>
                                @endif
                            </select>
                            @push('scripts')
                                <script>
                                    $(document).ready(function() {
                                        INITState();
                                        $("#country_id").on('change', function() {
                                            if ($('#state_id').has('select2-hidden-accessible')) {
                                                $('#state_id').select2('destroy');
                                            }
                                            INITState();
                                        });
                                    });

                                    function INITState() {
                                        $('#state_id').select2({
                                            theme: 'bootstrap4',
                                            ajax: {
                                                url: route('ajaxSearch', {
                                                    'table': 'states'
                                                }),
                                                dataType: 'json',
                                                delay: 500,
                                                data: (params) => {
                                                    return {
                                                        term: params.term,
                                                        country_id: $('#country_id').val().join(',')
                                                    }
                                                },
                                                processResults: (data, params) => {
                                                    let results = [];
                                                    if (data.data.length > 0) {
                                                        results = data.data.map(item => {
                                                            return {
                                                                id: item.id,
                                                                text: item.full_name || item.name,
                                                            };
                                                        });
                                                    } else {
                                                        const shouldInsert = true;
                                                        if (params.term != undefined && params.term.length > 2 && shouldInsert) {
                                                            results[0] = {
                                                                id: params.term,
                                                                text: params.term
                                                            }
                                                        }
                                                    }
                                                    return {
                                                        results: results,
                                                    }
                                                },
                                            },
                                        });
                                    }
                                </script>
                            @endpush
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <!-- text input -->
                        <div class="form-group">
                            <label> City</label>
                            <select class="form-control" id="city_id" multiple name="city_id">
                                @if (!empty($hospital->cities))
                                    @foreach ($hospital->cities as $data)
                                        <option value="{{ $data->id }}" selected>
                                            {{ $data->name }}
                                        </option>
                                    @endforeach
                                @else
                                    <option value="">Select Option</option>
                                @endif
                            </select>
                            @push('scripts')
                                <script>
                                    (function() {
                                        $(document).ready(function() {
                                            INITSelect();
                                            $("#country_id").on('change', function() {
                                                if ($('#city_id').has('select2-hidden-accessible')) {
                                                    $('#city_id').select2('destroy');
                                                }
                                                INITSelect();
                                            });
                                            $("#state_id").on('change', function() {
                                                if ($('#city_id').has('select2-hidden-accessible')) {
                                                    $('#city_id').select2('destroy');
                                                }
                                                INITSelect();
                                            });

                                            function INITSelect() {
                                                $('#city_id').select2({
                                                    theme: 'bootstrap4',
                                                    ajax: {
                                                        url: route('ajaxSearch', {
                                                            'table': 'cities'
                                                        }),
                                                        dataType: 'json',
                                                        delay: 500,
                                                        data: (params) => {
                                                            return {
                                                                term: params.term,
                                                                country_id: $('#country_id').val().join(','),
                                                                state_id: $('#state_id').val() != null ? $('#state_id').val()
                                                                    .join(',') : '',
                                                            }
                                                        },
                                                        processResults: (data, params) => {
                                                            let results = [];
                                                            if (data.data.length > 0) {
                                                                results = data.data.map(item => {
                                                                    return {
                                                                        id: item.id,
                                                                        text: item.full_name || item.name,
                                                                    };
                                                                });
                                                            } else {
                                                                const shouldInsert = true;
                                                                if (params.term != undefined && params.term.length > 2 &&
                                                                    shouldInsert) {
                                                                    results[0] = {
                                                                        id: params.term,
                                                                        text: params.term
                                                                    }
                                                                }
                                                            }
                                                            return {
                                                                results: results,
                                                            }
                                                        },
                                                    },
                                                });
                                            }
                                        });
                                    })();
                                </script>
                            @endpush
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-12">
                        <!-- text input -->
                        <div class="form-group">
                            <label>Description</label>
                            <textarea class="form-control" name="description" id="" cols="30" rows="10">{{ $hospital->description }}</textarea>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <!-- text input -->
                        <div class="form-group">
                            <x-form-image-input label="Logo" name="logo" :multiple="false" :defaultImages="$hospital
                                ->getMedia('logo')
                                ->first()
                                ?->getUrl()" />
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <x-multi-select-search label="Accreditation" name="accreditations" table="accreditations"
                                :multiple="true" :selectedOptions="$hospital->accreditation" :shouldInsert="true" />
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <x-multi-select-search label="Treatments" name="treatments" table="treatments" :multiple="true"
                                :selectedOptions="$hospital->treatments" />
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            @php
                                $doctors = [];
                                foreach ($hospital->doctors as $d) {
                                    $option = new stdClass();
                                    $option->id = $d->id;
                                    $option->name = $d->user->name;
                                    $doctors[] = $option;
                                }
                            @endphp
                            <x-multi-select-search label="Doctors" name="doctors" table="doctors" :multiple="true"
                                :selectedOptions="$doctors" />
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Map Embed Link</label>
                            <input type="text" class="form-control" placeholder="Google map embed links"
                                name="geo_location" value="{{ $hospital->geo_location }}">
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <!-- text input -->
                        <div class="form-group">
                            <label>Listing Placement Order in App</label>
                            <input type="number" class="form-control" placeholder="Sponsorship order" name="order">
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


    <div class="row">
        <div class="col-md-12">
            <div class="card card-default">
                <div class="card-header">
                    <h3 class="card-title">Hospital Gallery</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('hospitals.gallery.add', ['hospital' => $hospital->id]) }}" class="dropzone" id="my-awesome-dropzone">
                        @csrf

                    </form>
                </div>

            </div>

        </div>
    </div>
@endsection

@push('plugin-scripts')
    <script src="{{ asset('plugins/select2/js/select2.full.min.js') }}"></script>
    <script src="{{ asset('plugins/bs-custom-file-input/bs-custom-file-input.min.js') }}"></script>
    <script src="{{ asset('plugins/moment/moment.min.js') }}"></script>
    <script src="{{ asset('plugins/inputmask/jquery.inputmask.min.js') }}"></script>
    <script src="{{ asset('plugins/daterangepicker/daterangepicker.js') }}"></script>
    <script src="{{ asset('plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"></script>
    <script src="https://unpkg.com/dropzone@5/dist/min/dropzone.min.js"></script>
@endpush

@push('scripts')
    <script>
        $(function() {
            bsCustomFileInput.init();
            $('[data-mask]').inputmask();
        });
        $('.select2bs4').select2({
            theme: 'bootstrap4'
        });
    </script>
@endpush
