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
            <h3 class="card-title">Notifications Sent</h3>
            <a href="{{ route('notification.create') }}" class="btn btn-success btn-sm">
                <i class="fa fa-plus"></i> Send Notification
            </a>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
            <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th>User</th>
                    <th>Title</th>
                    <th>Body</th>
                    <th>Status</th>
                </tr>
                </thead>
                <tbody>
                @forelse($notifications as $data)
                    <tr>
                        <td>{{ $data->user_id }}</td>
                        <td>
                            {{ $data->notification_title }}
                        </td>
                        <td><span>{{ $data->notification_body  }}</span></td>
                        <td class="text-right">
                            {{ $data->status ? 'Success' : 'Fail'}}
                        </td>
                    </tr>
                @empty
                @endforelse

                </tbody>
                
            </table>
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
