@extends('layouts.user_type.auth')
@push('plugin-styles')
    <link rel="stylesheet" href="{{ asset("plugins/daterangepicker/daterangepicker.css")}}">
    <link rel="stylesheet" href="{{ asset("plugins/select2/css/select2.min.css")}}">
    <link rel="stylesheet" href="{{ asset("plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css")}}">
    <link rel="stylesheet" href="{{ asset("plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css")}}">
@endpush
@section('content')
    <div class="row">
        <div class="col-md-6">
            <form class="card card-primary" action="{{ route('settings.update') }}" method="post">
                @csrf
                <div class="card-header">
                    <h3 class="card-title">Default HCF Settings</h3>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        @if(!empty($settings['hcf_english']))
                            <x-multi-select-search label="Default HCF English" name="hcf_english" table="hcf"
                                                   :multiple="false" :selectedOptions="$settings['hcf_english']"/>
                        @else
                            <x-multi-select-search label="Default HCF English" name="hcf_english" table="hcf"
                                                   :multiple="false"/>
                        @endif
                    </div>
                    <div class="form-group">
                        @if(!empty($settings['hcf_arabic']))
                            <x-multi-select-search label="Default HCF Arabic" name="hcf_arabic" table="hcf"
                                                   :multiple="false" :selectedOptions="$settings['hcf_arabic']"/>
                        @else
                            <x-multi-select-search label="Default HCF Arabic" name="hcf_arabic" table="hcf"
                                                   :multiple="false"/>
                        @endif
                    </div>
                    <div class="form-group">
                        @if(!empty($settings['hcf_russian']))
                            <x-multi-select-search label="Default HCF Russian" name="hcf_russian" table="hcf"
                                                   :multiple="false" :selectedOptions="$settings['hcf_russian']"/>
                        @else
                            <x-multi-select-search label="Default HCF Russian" name="hcf_russian" table="hcf"
                                                   :multiple="false"/>
                        @endif

                    </div>
                    <div class="form-group">
                        @if(!empty($settings['hcf_hindi']))
                            <x-multi-select-search label="Default HCF Hindi" name="hcf_hindi" table="hcf"
                                                   :multiple="false" :selectedOptions="$settings['hcf_hindi']"/>
                        @else
                            <x-multi-select-search label="Default HCF Hindi" name="hcf_hindi" table="hcf"
                                                   :multiple="false"/>
                        @endif

                    </div>
                </div>

                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
        <div class="col-md-6">
            <form class="card card-primary" action="{{ route('settings.update') }}" method="post">
                @csrf
                <div class="card-header">
                    <h3 class="card-title">APP Settings</h3>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label class="form-label" for="">App Privacy Policy</label>
                        <textarea class="form-control" name="privacy_policy" id="" cols="30"
                                  rows="10">{{ $settings['privacy_policy']??'' }}</textarea>
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>

        <div class="col-md-6">
            <form class="card card-primary" action="" enctype="multipart/form-data">
                <div class="card-header">
                    <h3 class="card-title">App Banners</h3>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label for="exampleInputFile">Photos</label>
                        <div class="input-group">
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" name="banners[]" id="upload-photos"
                                       multiple>
                                <input type="hidden" name="photo_names"/>
                                <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                            </div>

                        </div>
                    </div>
                    <div class="file-preview">
                        <div class="card">
                            <div class="card-body">
                                <p class="text-center"> Previews will be available here</p>
                                <div class="row" id="img-preview-container">

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>

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
        var imageNames = [];
        @if(!empty($settings->banners))
            imageNames = '{{ $settings->banners }}'.split(',');
        @endif
        $('#upload-photos').on('change', function (event) {
            for (var i = 0; i < $(this).get(0).files.length; ++i) {
                imageNames.push($(this).get(0).files[i].name);
                var src = (window.URL || window.webkitURL).createObjectURL($(this).get(0).files[i]);
                var image = `<div class="col-md-4"><div class="img-preview-upload"><span class="remove-image" data-image='${imageNames[i]}'><img
                                                        src="{{ asset('assets/img/trash-outline.svg') }}" alt=""></span><img src="${src}" class="d-block img-responsive"alt=""></div></div>`;
                $("#img-preview-container").append(image);
            }
            $("input[name='photo_names']").val(imageNames.join(','));
        });

        $(document).on('click', '.remove-image', function () {
            let image = $(this).data('image');
            $(this).parent().parent().remove();
            const index = imageNames.indexOf(image);
            if (index > -1) { // only splice array when item is found
                imageNames.splice(index, 1); // 2nd parameter means remove one item only
            }
            $("input[name='photo_names']").val(imageNames.join(','));
        });
    </script>
@endpush
