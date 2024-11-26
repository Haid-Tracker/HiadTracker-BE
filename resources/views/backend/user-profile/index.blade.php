@extends('backend.layouts.app')

@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>User Profiles Management</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <a href="{{ route('user-profiles.create') }}" class="btn btn-primary">Add Profile</a>
                </ol>
            </div>
        </div>
    </div>
</section>

<section class="content">
    @if (session('status'))
        <div class="alert alert-success alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            {{ session('status') }}
        </div>
    @endif

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">User Profiles List</h3>
        </div>
        <div class="card-body">
            <table id="example1" class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>Profile ID</th>
                        <th>User Name</th>
                        <th>Photo</th>
                        <th>Birth Date</th>
                        <th>Weight</th>
                        <th>Height</th>
                        <th>Cycle Length</th>
                        <th>Last Period Date</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($profiles as $profile)
                    <tr>
                        <td>{{ $profile->id }}</td>
                        <td>{{ $profile->user->name }}</td>
                        <td>
                            @if($profile->photo)
                                <img src="{{ asset('storage/assets/images/profile/' . $profile->photo) }}"
                                     alt="Profile Photo"
                                     style="max-width: 50px;">
                            @else
                                No Photo
                            @endif
                        </td>
                        <td>{{ $profile->birth_date }}</td>
                        <td>{{ $profile->weight }} kg</td>
                        <td>{{ $profile->height }} cm</td>
                        <td>{{ $profile->cycle_length }} days</td>
                        <td>{{ $profile->last_period_date }}</td>
                        <td>
                            <a href="{{ route('user-profiles.edit', $profile->id) }}" class="btn btn-sm btn-info">
                                <i class="fas fa-edit"></i>
                            </a>
                            <button type="button" class="btn btn-sm btn-danger"
                                    data-toggle="modal"
                                    data-target="#deleteModal"
                                    data-delete-url="{{ route('user-profiles.destroy', $profile->id) }}">
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
