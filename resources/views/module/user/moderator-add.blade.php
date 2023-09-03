<?php
$selectedLanguage = [];
if (isset($user)) {
    $selectedLanguage = $user->languages->pluck('id')->toArray();
}
?>

@extends('layouts.user_type.auth')
@push('plugin-styles')
    <link rel="stylesheet" href="{{ asset('plugins/daterangepicker/daterangepicker.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">
@endpush
@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">{{ isset($user) ? 'Edit' : 'Add' }} a Moderator</h3>
        </div>
        <form action="{{ !isset($user) ? route('moderators.store') : route('moderators.update', ['user' => $user]) }}"
            method="post" enctype="multipart/form-data">
            <!-- /.card-header -->
            <div class="card-body">

                @csrf
                <div class="row">
                    <div class="col-sm-6">
                        <!-- text input -->
                        <div class="form-group">
                            <x-form-image-input label="Moderator Photo" name="image" />
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <!-- text input -->
                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" class="form-control" placeholder="Enter name" name="name"
                                value="{{ !empty($user) ? $user->name : '' }}">
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <!-- text input -->
                        <div class="form-group">
                            <label>Phone Number</label>
                            <div class="input-group">
                                <div class="input-group-prepend w-25">
                                    <select name="country_code" id="" class="form-select">
                                        @foreach (\App\Constants\CountryCodes::getList() as $data)
                                            <option value="{{ $data['dial_code'] }}"
                                                @if (!empty(old('country_code')) && old('country_code') == $data['dial_code']) selected @endif
                                                @if ($data['code'] == 'IN') selected @endif>
                                                {{ $data['code'] }}
                                                ({{ $data['dial_code'] }})
                                            </option>
                                        @endforeach
    
                                    </select>
                                </div>
                                <input type="number" title="Enter valid mobile number" class="form-control"
                                    placeholder="Enter phone number" value="{{ !empty($user) ? $user->phone : '' }}"
                                    name="phone">
                            </div>
                        </div>
                        
                    </div>
                    <div class="col-sm-6">
                        <!-- text input -->
                        <div class="form-group">
                            <label>Password</label>
                            <input type="text" class="form-control" placeholder="Enter password" name="password" />
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <!-- text input -->
                        <div class="form-group">
                            <label>Gender</label>
                            <select name="gender" id="" class="form-control">
                                <option value="male"
                                    {{ !empty($user) ? ($user->gender == 'male' ? 'selected' : '') : '' }}>
                                    Male
                                </option>
                                <option value="female"
                                    {{ !empty($user) ? ($user->gender == 'female' ? 'selected' : '') : '' }}>
                                    Female
                                </option>
                            </select>
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <!-- text input -->
                        <div class="form-group">
                            <label>Language</label>
                            <select name="language[]" id="" class="form-control select2bs4" multiple>
                                @foreach ($languages as $language)
                                    <option value="{{ $language->id }}" @if (in_array($language->id, $selectedLanguage)) selected @endif>
                                        {{ $language->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <div class="form-group">
                            <div class="custom-control custom-switch">
                                <input type="checkbox" class="custom-control-input" id="customSwitch1" name="is_active"
                                    {{ !empty($user) ? ($user->is_active ? 'checked' : '') : '' }}>
                                <label class="custom-control-label" for="customSwitch1">Moderator Active
                                    Status</label>
                            </div>
                        </div>
                    </div>
                </div>


            </div>
            <!-- /.card-body -->
            <div class="card-footer">
                <button class="btn btn-success btn-xl">Submit</button>
            </div>
        </form>
    </div>
@endsection

@push('plugin-scripts')
    <script src="{{ asset('plugins/select2/js/select2.full.min.js') }}"></script>
    <script src="{{ asset('plugins/bs-custom-file-input/bs-custom-file-input.min.js') }}"></script>
    <script src="{{ asset('plugins/moment/moment.min.js') }}"></script>
    <script src="{{ asset('plugins/inputmask/jquery.inputmask.min.js') }}"></script>
    <script src="{{ asset('plugins/daterangepicker/daterangepicker.js') }}"></script>
    <script src="{{ asset('plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"></script>
@endpush

@push('scripts')
    <script>
        $(function() {
            bsCustomFileInput.init();
            $('[data-mask]').inputmask();
        });
        // $('.selec')
        $('.select2bs4').select2({
            theme: 'bootstrap4',
            placeholder: "Select a language"
        });
    </script>
@endpush
