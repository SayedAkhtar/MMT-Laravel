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

<body>
    <div class="wrapper">

        <div class="container" style="min-height: 2646.62px;">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        @include('components.flash-message')
                    </div>
                </div>
            </div>
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1>Account deletion request</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="https://mymedtrip.com" target="_blank">Home</a></li>
                            </ol>
                        </div>
                    </div>
                </div>
            </section>

            <section class="content">

                <div class="card">
                    <div class="card-body row">
                        <div class="col-5 text-center d-flex align-items-center justify-content-center">
                            <div class="">
                                <h2>MyMedTrip</h2>
                                <h5>Please fill the form one of our representative will contact you to full fill your request</h5>
                            </div>
                        </div>
                        <div class="col-7">
                            <form action="{{route('requestDelete')}}" method="post">
                                @csrf
                                <div class="form-group">
                                    <label for="inputName">Name</label>
                                    <input type="text" id="inputName" class="form-control" name="name" required>
                                </div>
                                <div class="form-group">
                                    <label for="inputEmail">Phone Number</label>
                                    <input type="number" id="inputEmail" class="form-control" name="phone" required>
                                </div>
                                <div class="form-group">
                                    <label for="inputSubject">Subject</label>
                                    <input type="text" id="inputSubject" class="form-control" value="Account Deletion Request" disabled>
                                </div>
                                <div class="form-group">
                                    <label for="inputMessage">Message</label>
                                    <textarea id="inputMessage" class="form-control" rows="4" name="message" required></textarea>
                                </div>
                                <div class="form-group">
                                    <input type="submit" class="btn btn-primary" value="Send message">
                                </div>
                            </form>
                            
                        </div>
                    </div>
                </div>
            </section>

        </div>

        <footer class="main-footer">
            <div class="float-right d-none d-sm-block">
                <b>Version</b> 3.2.0
            </div>
            <strong>Copyright © 2014-2021 <a href="https://adminlte.io">AdminLTE.io</a>.</strong> All rights reserved.
        </footer>
    </div>

</body>

</html>
