@extends('layouts.user_type.auth')
@push('plugin-styles')
    <link rel="stylesheet" href="{{ asset("plugins/datatables-bs4/css/dataTables.bootstrap4.min.css") }}">
    <link rel="stylesheet" href="{{ asset("plugins/datatables-responsive/css/responsive.bootstrap4.min.css")}}">
    <link rel="stylesheet" href="{{ asset("plugins/datatables-buttons/css/buttons.bootstrap4.min.css")}}">
@endpush
@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3 class="card-title">Doctors List</h3>
            <a href="javascript:void(0)" class="btn btn-success btn-sm" data-toggle="modal" data-target="#add_designation">
                <i class="fa fa-plus"></i> Add Designation
            </a>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
            <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                @foreach($designations as $data)
                    <tr>
                        <td>{{ $data->id }}</td>
                        <td>{{ $data->name }}</td>
                        <td class="text-right">
                            <a href="#" class="btn btn-info btn-sm" data-toggle="modal" data-target="#edit_designation"><i class="fa fa-edit"></i></a>
                            <a href="#" class="btn btn-danger btn-sm"><i class="fa fa-trash-alt"></i></a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
                <tfoot>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Actions</th>
                </tr>
                </tfoot>
            </table>
        </div>
        <!-- /.card-body -->
    </div>
@endsection

@extends('components.modal', ['title' => "Add Designation", 'form_id' => 'add_designation'])
@section('modal-body')
    <form action="{{ route('designation.store') }}" method="post" id="add_designation">
        @csrf
        <div class="form-group">
            <label for="designation_name">Designation name</label>
            <input type="text" class="form-control" id="designation_name" name="name" placeholder="Enter designation">
        </div>
    </form>
@endsection

@extends('components.modal', ['title' => "Add Designation", 'form_id' => 'edit_designation'])

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
    <script>
        $('#example1').DataTable({
            "paging": true,
            "lengthChange": false,
            "searching": false,
            "ordering": true,
            "info": true,
            "autoWidth": false,
            "responsive": true,
        });
    </script>

    <script>
        $(document).on('ready', function (){

        });
    </script>
@endpush