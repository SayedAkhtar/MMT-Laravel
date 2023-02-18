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
    <link rel="stylesheet" href="{{ asset("plugins/fontawesome-free/css/all.min.css") }}">
    <!-- IonIcons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Theme style -->
    @stack('plugin-styles')
    <link rel="stylesheet" href="{{ asset("/css/style.css") }}">
    @stack('page-styles')
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
        <strong>Copyright &copy; 2014-2021 <a href="https://mymedtrip.com/" target="_blank">MyMedTrip</a>.</strong>
        All rights reserved.
        <div class="float-right d-none d-sm-inline-block">
            <b>Version</b> 1.0.0
        </div>
    </footer>
</div>
<!-- jQuery -->
<script src="{{ asset("plugins/jquery/jquery.min.js") }}"></script>
<!-- Bootstrap -->
<script src="{{ asset("plugins/bootstrap/js/bootstrap.bundle.min.js") }}"></script>
{{-- Plugin Scripts--}}
@stack('plugin-scripts')
<!-- AdminLTE -->
<script src="{{ asset("js/adminlte.js") }}"></script>
<!-- OPTIONAL SCRIPTS -->
<script src="{{ asset("plugins/chart.js/Chart.min.js") }}"></script>
@stack('scripts')
@livewireScripts
</body>
</html>