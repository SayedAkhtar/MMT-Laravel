@extends('layouts.user_type.auth')
@push('plugin-styles')
    <link rel="stylesheet" href="{{ asset("plugins/datatables-bs4/css/dataTables.bootstrap4.min.css") }}">
    <link rel="stylesheet" href="{{ asset("plugins/datatables-responsive/css/responsive.bootstrap4.min.css")}}">
    <link rel="stylesheet" href="{{ asset("plugins/datatables-buttons/css/buttons.bootstrap4.min.css")}}">
@endpush
@push('page-styles')
    <style>
        .accreditation-img {
            height: 50px;
            margin: 0 auto;
            display: block;
        }
    </style>
@endpush
@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3 class="card-title">HCF List</h3>
            <a href="{{ route('moderators.create') }}" class="btn btn-success btn-sm">
                <i class="fa fa-plus"></i> Add HCF
            </a>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
            <div class="row">
                @forelse($moderators as $data)
                    <div class="col-md-4">
                        <div class="card card-widget widget-user-2 shadow-sm">
                            <div class="widget-user-header bg-warning">
                                <div class="widget-user-image">
                                    <img class="img-circle elevation-2" src="{{ image_path($data->image) }}"
                                         alt="User Avatar">
                                </div>
                                <a href="{{ route('moderators.edit', ['user' => $data->id]) }}"><h3
                                        class="widget-user-username">{{ $data->name }}</h3></a>
                                <h5 class="widget-user-desc">{{ $data->phone }}</h5>
                            </div>
                            <div class="card-footer p-0">
                                <ul class="nav flex-column">
                                    <li class="nav-item">
                                        <a href="#" class="nav-link">
                                            Total Queries <span
                                                class="float-right badge bg-primary">{{ $data->confirmedQuery->count() }}</span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="#" class="nav-link">
                                            Active Queries <span
                                                class="float-right badge bg-info">{{ $data->pending_queries }}</span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="#" class="nav-link">
                                            Queries Completed <span
                                                class="float-right badge bg-success">{{ $data->completed_queries }}</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>

                    </div>
                @empty
                    <h2>No HCF added</h2>
                @endforelse
            </div>
        </div>
        <!-- /.card-body -->
    </div>
@endsection

@push('plugin-scripts')
    <script src="{{ asset("plugins/datatables/jquery.dataTables.min.js")}}"></script>
    <script src="{{ asset("plugins/datatables-bs4/js/dataTables.bootstrap4.min.js")}}"></script>
    <script src="{{ asset("plugins/datatables-responsive/js/dataTables.responsive.min.js")}}"></script>
    <script src="{{ asset("plugins/datatables-responsive/js/responsive.bootstrap4.min.js")}}"></script>
    <script src="{{ asset("plugins/datatables-buttons/js/dataTables.buttons.min.js")}}"></script>
    <script src="{{ asset("plugins/datatables-buttons/js/buttons.bootstrap4.min.js")}}"></script>
    <script src="{{ asset("plugins/jszip/jszip.min.js")}}"></script>
    <script src="{{ asset("plugins/pdfmake/pdfmake.min.js")}}"></script>
    <script src="{{ asset("plugins/pdfmake/vfs_fonts.js")}}"></script>
    <script src="{{ asset("plugins/datatables-buttons/js/buttons.html5.min.js")}}"></script>
    <script src="{{ asset("plugins/datatables-buttons/js/buttons.print.min.js")}}"></script>
    <script src="{{ asset("plugins/datatables-buttons/js/buttons.colVis.min.js")}}"></script>
@endpush

@push('scripts')

@endpush
