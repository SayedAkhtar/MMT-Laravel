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
            <h3 class="card-title">Consultation List</h3>
            {{--            <a href="{{ route('tests.create') }}" class="btn btn-success btn-sm">--}}
            {{--                <i class="fa fa-plus"></i> Add Test--}}
            {{--            </a>--}}
        </div>
        <!-- /.card-header -->
        <div class="card-body">
            <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th></th>
                    <th>Consultation ID</th>
                    <th>Doctor</th>
                    <th>Patient</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                @forelse($consultation as $data)
                    <tr>
                        <td>{{ $loop->index + 1 }}</td>
                        <td>TELE-{{ $data->id }}</td>
                        <td>{{ $data->doctor->user->name }}</td>
                        <td>{{ $data->patient->user->name }}</td>
                        <td><span>{{ $data->is_active?'Active' : 'False'  }}</span></td>
                        <td class="text-right">
                            <a href="{{ route('video-consultation.show', ['video_consultation' => $data->id]) }}"
                               class="btn btn-info btn-sm"><i class="fa fa-edit"></i></a>
                            <a href="#" class="btn btn-danger btn-sm"><i class="fa fa-trash-alt"></i></a>
                        </td>
                    </tr>
                @empty
                @endforelse

                </tbody>
                <tfoot>
                <tr>
                    <th></th>
                    <th>Consultation ID</th>
                    <th>Doctor</th>
                    <th>Patient</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
                </tfoot>
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
