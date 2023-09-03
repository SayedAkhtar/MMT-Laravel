<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>My Medical Trip | @yield('title', 'Dashboard') </title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">
    <!-- IonIcons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Theme style -->
    @stack('plugin-styles')
    <link rel="stylesheet" href="{{ asset('/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('/css/app.css') }}">
    <style>
        .link-unstyled,
        .link-unstyled:link,
        .link-unstyled:hover {
            color: inherit;
            text-decoration: inherit;
        }
    </style>
    @stack('page-styles')
    {{-- <script src="{{ asset('/js/agoraRTC3.3.1.js') }}"></script> --}}
    <script src="https://cdn.tiny.cloud/1/gyc4jmrsgkl20fnaut1r422tzwhr5flryj93sbgu4n0x0hmz/tinymce/6/tinymce.min.js"
        referrerpolicy="origin"></script>
    @livewireStyles
</head>

<body class="hold-transition sidebar-mini">
    <div class="wrapper">
        @include('layouts.navbars.auth.nav')
        @include('layouts.navbars.auth.sidebar')
        <div class="content-wrapper">
            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            @include('components.flash-message')
                        </div>
                    </div>
                </div>
            </section>

            <section class="content-header">
                <div class="container-fluid">
                    @include('layouts.navbars.auth.breadcrumb')
                </div>
            </section>
            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            @yield('content')
                        </div>
                    </div>
                </div>
            </section>
        </div>

        <footer class="main-footer">
            <strong>Copyright &copy; <a href="https://mymedtrip.com/" target="_blank">MyMedTrip</a>.</strong>
            All rights reserved.
            <div class="float-right d-none d-sm-inline-block">
                <b>Version</b> 1.0.0
            </div>
        </footer>
    </div>
    @stack('modals')
    <!-- jQuery -->
    <script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
    <!-- Bootstrap -->
    <script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    {{-- Plugin Scripts --}}
    @stack('plugin-scripts')
    <!-- AdminLTE -->
    <script src="{{ asset('js/adminlte.js') }}"></script>
    <!-- OPTIONAL SCRIPTS -->
    <script src="{{ asset('plugins/chart.js/Chart.min.js') }}"></script>
    @routes
    @stack('scripts')
    <script>
        $("button[data-action='delete']").click(async function(event) {
            let entity = $(this).data('entity');
            let route = $(this).data('route');
            let entityId = $(this).data('entity-id');
            let params = {};
            params[entity] = entityId;
            if (confirm("Are you sure. You want to DELETE ?")) {
                try {
                    $.ajax(route, {
                        method: 'delete',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        success: function(res) {
                            console.log(res.STATUS);
                            console.log(res);
                            if (res.STATUS == 'SUCCESS') {
                                window.location.href = window.location.href;
                            } else {
                                alert(res.DATA);
                            }
                        },
                        error: function(error) {
                            console.log(error);
                        }
                    })
                } catch (e) {
                    alert(e);
                }
            }
        })
    </script>
    @livewireScripts
    <script>
        tinymce.init({
            selector: 'textarea',
            plugins: 'preview importcss searchreplace autolink autosave save directionality code visualblocks visualchars fullscreen image link media template codesample table charmap pagebreak nonbreaking anchor insertdatetime advlist lists wordcount help charmap quickbars emoticons',
            toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table mergetags | addcomment showcomments | spellcheckdialog a11ycheck typography | align lineheight | checklist numlist bullist indent outdent | emoticons charmap | removeformat',
            tinycomments_mode: 'embedded',
            tinycomments_author: 'Author name',
            mergetags_list: [{
                    value: 'First.Name',
                    title: 'First Name'
                },
                {
                    value: 'Email',
                    title: 'Email'
                },
            ]
        });
    </script>
</body>

</html>
