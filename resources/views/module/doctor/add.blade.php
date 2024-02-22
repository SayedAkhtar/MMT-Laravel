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
            <h3 class="card-title">Add a doctor</h3>
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
                            <input type="text" class="form-control" placeholder="Enter name" name="name" @old('name') required>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Email</label>
                            <input type="email" class="form-control" @old('email')
                            placeholder="Enter email" name="email">
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Phone Number</label>
                            <div class="input-group">
                                <div class="input-group-prepend w-25">
                                    <select name="country_code" id="" class="form-select">
                                        @foreach(\App\Constants\CountryCodes::getList() as $data)
                                            <option value="{{ $data['dial_code'] }}"
                                                @if(!empty(old('country_code')) && old('country_code') == $data['dial_code']) 
                                                selected 
                                                @elseif($data['code'] == 'IN') 
                                                selected 
                                                @endif>
                                                {{ $data['code'] }}
                                                ({{ $data['dial_code'] }})
                                            </option>
                                        @endforeach

                                    </select>
                                </div>
                                <input type="text" class="form-control"
                                       placeholder="Enter phone number"
                                       name="phone">
                            </div>

                        </div>
                    </div>

                    <div class="col-sm-6">
                        <!-- text input -->
                        <div class="form-group">
                            <x-form-image-input label="Profile Image" name="image" :multiple="false"/>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Gender</label>
                            <select class="form-control" name="gender">
                                <option>Select Option</option>
                                <option value="male" @if(!empty(old('gender')) && old('gender') == 'male') selected @endif >Male</option>
                                <option value="female" @if(!empty(old('gender')) && old('gender') == 'female') selected @endif>Female</option>
                                <option value="other" @if(!empty(old('gender')) && old('gender') == 'other') selected @endif>Other</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <!-- text input -->
                        <div class="form-group">
                            <label> Country</label>
                            <select class="form-control" id="country_id"
                                    name="country_id">
                                <option value="">Select Option</option>
                            </select>
                            @push('scripts')
                                <script>
                                    $(document).ready(function () {
                                        $('#country_id').select2({
                                            theme: 'bootstrap4',
                                            ajax: {
                                                url: route('ajaxSearch', {'table': 'countries'}),
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
                                    });

                                </script>
                            @endpush
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <!-- text input -->
                        <div class="form-group">
                            <label> State</label>
                            <select class="form-control" id="state_id"
                                    name="state_id">
                                <option value="">Select Option</option>
                            </select>
                            @push('scripts')
                                <script>
                                    $(document).ready(function () {
                                        $("#country_id").on('change', function () {
                                            $('#state_id').select2({
                                                theme: 'bootstrap4',
                                                ajax: {
                                                    url: route('ajaxSearch', {'table': 'states'}),
                                                    dataType: 'json',
                                                    delay: 500,
                                                    data: (params) => {
                                                        return {
                                                            term: params.term,
                                                            country_id: $('#country_id').val()
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

                                    });

                                </script>
                            @endpush
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <!-- text input -->
                        <div class="form-group">
                            <label> City</label>
                            <select class="form-control" id="city_id"
                                    name="city_id" >
                                <option value="">Select Option</option>
                            </select>
                            @push('scripts')
                                <script>
                                    (function () {
                                        $(document).ready(function () {
                                            $("#country_id").on('change', function () {
                                                if ($('#city_id').has('select2-hidden-accessible')) {
                                                }
                                                INITSelect();
                                            });
                                            $("#state_id").on('change', function () {
                                                if ($('#city_id').has('select2-hidden-accessible')) {
                                                }
                                                INITSelect();
                                            });

                                            function INITSelect() {
                                                $('#city_id').select2({
                                                    theme: 'bootstrap4',
                                                    ajax: {
                                                        url: route('ajaxSearch', {'table': 'cities'}),
                                                        dataType: 'json',
                                                        delay: 500,
                                                        data: (params) => {
                                                            return {
                                                                term: params.term,
                                                                country_id: $('#country_id').val(),
                                                                state_id: $('#state_id').val(),
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
                                            }
                                        });
                                    })();


                                </script>
                            @endpush
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <!-- text input -->
                        <div class="form-group">
                            <x-multi-select-search label="Designation" name="designation_id" table="designations"
                                                   :multiple="true" :required="true" :shouldInsert="true"/>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <x-multi-select-search label="Qualification" name="qualification_id"
                                                   table="qualifications"
                                                   :multiple="true" :required="true" :shouldInsert="true" />
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <!-- text input -->
                        <div class="form-group">
                            <label>Awards</label>
                            <input type="text" class="form-control" placeholder="Enter name" name="awards" @old('awards') >
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
                                       data-inputmask-inputformat="mm/dd/yyyy" data-mask="" inputmode="numeric"
                                       name="start_of_service" required>
                            </div>
                            <!-- /.input group -->
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <x-multi-select-search label="Hospitals" name="hospital_id" table="hospitals"
                                                   :multiple="true"/>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <x-multi-select-search label="Specializations" name="specialization_id"
                                                   table="specializations"
                                                   :multiple="true" :required="true" :shouldInsert="true" />
                        </div>
                    </div>
                    {{-- <div class="col-sm-6">
                        <!-- text input -->
                        <div class="form-group">
                            <livewire:time-slots-component/>
                        </div>
                    </div> --}}
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Consultation Price: </label>
                            <input type="text" class="form-control" placeholder="Enter price in Dollars" name="price" @old('price') pattern="[0-9]{0,10}">
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <!-- text input -->
                        <div class="form-group">
                            <label>Description</label>
                            <textarea class="form-control" rows="3" placeholder="Enter ..."
                                      name="description"></textarea>
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
