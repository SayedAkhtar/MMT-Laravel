@extends('layouts.user_type.auth')
@push('plugin-styles')
    <link rel="stylesheet" href="{{ asset('plugins/daterangepicker/daterangepicker.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">
    <style>
        .img-preview-upload {
            width: 200px;
            height: 200px;
            object-fit: cover;
            padding: 5px;
            margin: 8px;
            box-sizing: border-box;
            position: relative;
            box-shadow: 0px 1px 20px rgba(0, 0, 0, 0.3);
        }

        .img-preview-upload>img {
            width: 100%;
            height: 100%;
        }

        .remove-image {
            width: 30px;
            height: 30px;
            background: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 8px;
            box-shadow: 0px 2px 10px rgba(0, 0, 0, 0.2);
            position: absolute;
            right: 8px;
            top: 10px;
            padding: 5px;
        }

        .remove-image img {
            display: block;
        }
    </style>
@endpush
@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Add a Testimony</h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
            <form action="{{ route('patient-testimonies.store') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-sm-4">
                        <div class="form-group">
                            
                            <x-multi-select-search label="Patient (Leave Empty for Demo User)" name="patient_id" table="patient" :multiple="false"
                                :required="false" />
                                
                        </div>
                        
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <x-multi-select-search label="Doctors" name="doctor_id" table="doctors" column="user_id" :multiple="false" />
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <x-multi-select-search label="Hospital" name="hospital_id" table="hospitals"
                                :multiple="false" />
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="exampleInputFile">Photos</label>
                            <div class="input-group">
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" name="images[]" id="upload-photos"
                                        multiple>
                                    <input type="hidden" name="photo_names" />
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
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="exampleInputFile">Youtube Links</label>
                            <div class="youtubeLinkValidationMessage" style="display: none; color: red;">Please enter a
                                valid YouTube link</div>
                            <div class="input-group">
                                <div id="tag-inputs" class="w-100">
                                    <input type="text" name="videos[]" class="form-control mb-2" pattern="(?:https?:\/\/)?(?:www\.)?(?:youtube\.com\/(?:[^\/\n\s]+\/\S+\/|(?:v|e(?:mbed)?)\/|\S*?[?&]v=)|youtu\.be\/)([a-zA-Z0-9_-]{11})" title="Please enter a valid YouTube link" placeholder="Enter Link" onblur="validateYouTubeLink(this)">
                                </div>
                                <button type="button" id="add-tag" class="btn btn-primary mt-2">Add More</button>
                            </div>
                            
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Textarea</label>
                            <textarea class="form-control" rows="3" placeholder="Enter ..." name="description"></textarea>
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
    <script src="{{ asset('plugins/select2/js/select2.full.min.js') }}"></script>
    <script src="{{ asset('plugins/bs-custom-file-input/bs-custom-file-input.min.js') }}"></script>
    <script src="{{ asset('plugins/moment/moment.min.js') }}"></script>
    <script src="{{ asset('plugins/inputmask/jquery.inputmask.min.js') }}"></script>
    <script src="{{ asset('plugins/daterangepicker/daterangepicker.js') }}"></script>
    <script src="{{ asset('plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"></script>
@endpush

@push('scripts')
    <script>
        var imageNames = [];


        $('#upload-photos').on('change', function(event) {
            for (var i = 0; i < $(this).get(0).files.length; ++i) {
                imageNames.push($(this).get(0).files[i].name);
                var src = (window.URL || window.webkitURL).createObjectURL($(this).get(0).files[i]);
                var image =
                    `<div class="col-md-4"><div class="img-preview-upload"><span class="remove-image" data-image='${imageNames[i]}'><img
                                                        src="{{ asset('assets/img/trash-outline.svg') }}" alt=""></span><img src="${src}" class="d-block img-responsive"alt=""></div></div>`;
                $("#img-preview-container").append(image);
            }
            $("input[name='photo_names']").val(imageNames.join(','));
        });

        $(document).on('click', '.remove-image', function() {
            let image = $(this).data('image');
            $(this).parent().parent().remove();
            const index = imageNames.indexOf(image);
            if (index > -1) { // only splice array when item is found
                imageNames.splice(index, 1); // 2nd parameter means remove one item only
            }
            $("input[name='photo_names']").val(imageNames.join(','));
        });


        $(document).ready(function() {
            $('#add-tag').click(function() {
                $('#tag-inputs').append(
                    '<input type="text" name="videos[]" class="form-control mb-2" pattern="(?:https?:\/\/)?(?:www\.)?(?:youtube\.com\/(?:[^\/\n\s]+\/\S+\/|(?:v|e(?:mbed)?)\/|\S*?[?&]v=)|youtu\.be\/)([a-zA-Z0-9_-]{11})" title="Please enter a valid YouTube link" placeholder="Enter Link" onblur="validateYouTubeLink(this)">'
                    );
            });
        });

        function validateYouTubeLink(event) {
            var linkInput = event;
            var validationMessage = $('.youtubeLinkValidationMessage');
            var youtubePattern =
                /^(?:(?:https?:)?\/\/)?(?:www\.)?(?:youtube\.com\/(?:[^\/\n\s]+\/\S+\/|(?:v|e(?:mbed)?)\/|\S*?[?&]v=)|youtu\.be\/)([a-zA-Z0-9_-]{11})$/;

            if (linkInput.value.trim() !== '' && !youtubePattern.test(linkInput.value)) {
                validationMessage.show();
                linkInput.focus();
            } else {
                validationMessage.hide();
            }
        }
    </script>
@endpush
