<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
            <a href="#" class="nav-link">Home</a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
            <a href="#" class="nav-link">Contact</a>
        </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
        <!-- Navbar Search -->
        <li class="nav-item">
            <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                <i class="fas fa-expand-arrows-alt"></i>
            </a>
        </li>
        <li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href="#" aria-expanded="false">
                Language ({{ session('language', 'en') }})
            </a>
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right" style="left: inherit; right: 0px;">
                <a href="#" class="dropdown-item" onclick="changeLanguage('en')">
                    <p>English (en)</p>
                </a>
                <div class="dropdown-divider"></div>
                <a href="#" class="dropdown-item" onclick="changeLanguage('bn')">
                    <p>Bengali (bn)</p>
                </a>
                <div class="dropdown-divider"></div>
                <a href="#" class="dropdown-item" onclick="changeLanguage('ru')">
                    <p>Russian (ru)</p>
                </a>
                <div class="dropdown-divider"></div>
                <a href="#" class="dropdown-item" onclick="changeLanguage('ar')">
                    <p>Arabic (ar)</p>
                </a>
            </div>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="{{ route('logout') }}"
                role="button">
                <i class="fas fa-power-off"></i>
            </a>
        </li>
    </ul>
</nav>

@push('scripts')
    <script>
        function changeLanguage(language){
            $.post("{{ route('change.language') }}",{
                'language': language,
                '_token': '{{ csrf_token() }}'
            }, function(data, status){
                if(status == 'success'){
                    window.location.reload();
                }
            })
        }
    </script>
@endpush
