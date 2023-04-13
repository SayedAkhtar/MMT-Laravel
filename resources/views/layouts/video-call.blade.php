<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>My Medical Trip | Doctor's Call Page </title>
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">
    @include('components.flash-message')
    <div id="app">
        <agora-chat :allusers="{{ $users }}" authuserid="{{ auth()->id() }}" authuser="{{ auth()->user()->name }}"
                    agora_id="{{ env('AGORA_APP_ID') }}"></agora-chat>
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
<script src="{{ mix('/js/app.js') }}"></script>
</body>
</html>
