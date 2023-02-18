<aside class="main-sidebar sidebar-dark-primary elevation-4">
  <!-- Brand Logo -->
  <a href="index3.html" class="brand-link">
    <img src="{{ asset('/img/logo.png') }}" alt="AdminLTE Logo" class="brand-image" style="opacity: .8">
    <span class="brand-text font-weight-light"> Admin</span>
  </a>

  <!-- Sidebar -->
  <div class="sidebar">

    <!-- SidebarSearch Form -->
    <div class="form-inline">
      <div class="input-group" data-widget="sidebar-search">
        <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
        <div class="input-group-append">
          <button class="btn btn-sidebar">
            <i class="fas fa-search fa-fw"></i>
          </button>
        </div>
      </div>
    </div>

    <!-- Sidebar Menu -->
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <li class="nav-item">
          <a href="#" class="nav-link">
            <i class="nav-icon fas fa-th"></i>
            <p>
              Home
            </p>
          </a>
        </li>
        <li class="nav-item">
          <a href="#" class="nav-link">
            <i class="nav-icon fas fa-copy"></i>
            <p>
              Doctor
              <i class="fas fa-angle-left right"></i>
{{--              <span class="badge badge-info right">6</span>--}}
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="{{ route('doctors.index') }}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>List</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('designations.index') }}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Designation</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="#" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Treatment</p>
              </a>
            </li>
          </ul>
        </li>

        <li class="nav-header">Settings</li>
        <li class="nav-item">
          <a href="{{ route('profile.index') }}" class="nav-link">
            <i class="nav-icon fas fa-calendar-alt"></i>
          </a>
        </li>

      </ul>
    </nav>
    <!-- /.sidebar-menu -->
  </div>
  <!-- /.sidebar -->
</aside>