@extends('layouts.user_type.auth')
@push('plugin-styles')
    <link rel="stylesheet" href="{{ asset("plugins/datatables-bs4/css/dataTables.bootstrap4.min.css") }}">
    <link rel="stylesheet" href="{{ asset("plugins/datatables-responsive/css/responsive.bootstrap4.min.css")}}">
    <link rel="stylesheet" href="{{ asset("plugins/datatables-buttons/css/buttons.bootstrap4.min.css")}}">
@endpush
@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3 class="card-title">Queries List</h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
            <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Patient Phone</th>
                    <th>Query Type</th>
                    <th>Country</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                @foreach($queries as $data)
                    <tr>
                        <td>{{ $data->id }}</td>
                        <td>{{ $data->patient->phone }}</td>
                        <td>{{ $data->query_type }}</td>
                        <td>{{ $data->preferred_country?? "No Preference"}}</td>
                        <td>{{ $data->status }}</td>
                        <td class="text-right">
                            <a href="{{ route('query.show', ['query' => $data->id]) }}" class="btn btn-info btn-sm"><i
                                    class="fa fa-edit"></i></a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        <!-- /.card-body -->
    </div>
@endsection

@push('modals')
    <div class="modal fade" id="add_designation">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Add Designation</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('designations.store') }}" method="post" id="add_designation">
                        @csrf
                        <div class="form-group">
                            <label for="designation_name">Designation name</label>
                            <input type="text" class="form-control" id="designation_name" name="name"
                                   placeholder="Enter designation">
                        </div>
                    </form>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" form="add_designation" class="btn btn-primary">Save changes</button>
                </div>
            </div>
        </div>
    </div>

    {{-----------    EDIT MODAL -------------}}
    <div class="modal fade" id="edit_designation">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Add Designation</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="#" method="post" id="edit_designation-form">
                        @csrf
                        <div class="form-group">
                            <label for="designation_name">Designation name</label>
                            <input type="text" class="form-control" id="designation_name" name="name"
                                   placeholder="Enter designation">
                        </div>
                        <div class="form-group">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="is_active">
                                <label class="form-check-label">Active</label>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" form="edit_designation-form" class="btn btn-primary">Save changes</button>
                </div>
            </div>
        </div>
    </div>
@endpush


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
        async function edit(id) {
            let res = await fetch(route('designation.show', {'designation': id}));
            let data = await res.json();
            $form = $("#edit_designation-form input");
            $("#edit_designation-form").attr('action', route('designation.update', {'designation': id}));
            console.log($form.action);
            $form.each((index, ele) => {
                if (data.data[ele.name] == undefined) {
                    return;
                }
                if (typeof data.data[ele.name] == 'boolean') {
                    ele.checked = data.data[ele.name]
                } else {
                    ele.value = data.data[ele.name];
                }
                $("#edit_designation").modal().show();
            });
            console.log(data);
        }
    </script>
@endpush
