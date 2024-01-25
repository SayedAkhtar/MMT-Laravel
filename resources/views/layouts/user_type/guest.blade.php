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
@section('guest')
                
        @include('layouts.footers.guest.footer')
@endsection

</body>

</html>
