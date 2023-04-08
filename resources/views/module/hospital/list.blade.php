@extends('layouts.user_type.auth')
@push('plugin-styles')
    <link rel="stylesheet" href="{{ asset("plugins/datatables-bs4/css/dataTables.bootstrap4.min.css") }}">
    <link rel="stylesheet" href="{{ asset("plugins/datatables-responsive/css/responsive.bootstrap4.min.css")}}">
    <link rel="stylesheet" href="{{ asset("plugins/datatables-buttons/css/buttons.bootstrap4.min.css")}}">
@endpush
@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3 class="card-title">Hospitals List</h3>
            <a href="{{ route('hospitals.create') }}" class="btn btn-success btn-sm">
                <i class="fa fa-plus"></i> Add Hospital
            </a>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
            <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th>Id</th>
                    <th>Name</th>
                    <th>Address</th>
                    <th>Accreditation</th>
                    <th>Treatments</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                @forelse($hospitals as $data)
                    <tr>
                        <td>{{ $loop->index + 1 }}</td>
                        <td>{{ $data->name }}</td>
                        <td>{{ $data->address }}</td>
                        <td> {{ !empty($data->accreditation)? $data->accreditation->pluck('name')->join(',') : "No accreditation yet" }}</td>
                        <td> {{ !empty($data->treatments)? $data->treatments->pluck('name')->join(',') : "No treatments yet" }}</td>
                        <td class="text-right">
                            <a href="{{ route('hospitals.show', ['hospital'=> $data->id]) }}"
                               class="btn btn-info btn-sm"><i class="fa fa-edit"></i></a>
                            <button class="btn btn-danger btn-sm" data-action="delete"
                                    data-route="{{ route('hospitals.destroy', ['hospital' => $data->id]) }}"
                                    data-entity="hospital"
                                    data-entity-id="{{ $data->id }}"><i class="fa fa-trash-alt"></i></button>
                        </td>
                    </tr>
                @empty
                @endforelse

                </tbody>
                <tfoot>
                <tr>
                    <th>Id</th>
                    <th>Name</th>
                    <th>Address</th>
                    <th>Accreditation</th>
                    <th>Treatments</th>
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
