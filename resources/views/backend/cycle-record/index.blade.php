@extends('backend.layouts.app')

@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Cycle - Record Management</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <a href="{{ route('admin.cycle-record.create') }}" class="btn btn-primary">Add Record</a>
                </ol>
            </div>
        </div>
    </div>
</section>

<section class="content">
    @if (session('success'))
        <div class="alert alert-success alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            {{ session('success') }}
        </div>
    @endif

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">User Cycle - Record</h3>
        </div>
        <div class="card-body">
            <table id="example1" class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>User Name</th>
                        <th>Start Date</th>
                        <th>End Date</th>
                        <th>Predicted Date</th>
                        <th>Mood </th>
                        <th>Feedback Status</th>
                        <th>Updated At</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($datas as $data)
                    <tr>
                        <td>{{ $data->user_name }}</td>
                        <td>{{ $data->start_date }}</td>
                        <td>{{ $data->end_date }}</td>
                        <td>{{ $data->predicted_date }}</td>
                        <td>{{ $data->mood }}</td>
                        <td>{{ $data->feedback?->status ?? 'N/A' }}</td>
                        <td>{{ $data->updated_at }}</td>
                        <td>
                            <a href="{{ route('admin.cycle-record.show', $data->id) }}" class="btn btn-sm btn-primary">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ route('admin.cycle-record.edit', $data->id) }}" class="btn btn-sm btn-info">
                                <i class="fas fa-edit"></i>
                            </a>
                            <button type="button" class="btn btn-sm btn-danger"
                                    data-toggle="modal"
                                    data-target="#deleteModal"
                                    data-delete-url="{{ route('admin.cycle-record.destroy', $data->id) }}">
                                <i class="fas fa-trash"></i>
                            </button>


                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</section>

<!--  Delete Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">Delete Confirmation</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Are you sure you want to delete this profile?
            </div>
            <div class="modal-footer">
                <form id="deleteForm" method="POST" action="">
                    @csrf
                    @method('DELETE')
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>


            </div>
        </div>
    </div>
</div>
@endsection

@section('js-section')
<script>
    $(function () {
        $("#example1").DataTable({
            "responsive": true,
            "lengthChange": true,
            "autoWidth": false,
            "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
        }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');

        // Delete Modal
        $('#deleteModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var deleteUrl = button.data('delete-url');
            var modal = $(this);
            modal.find('#deleteForm').attr('action', deleteUrl);
        });
    });
</script>
@endsection
