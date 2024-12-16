@extends('backend.layouts.app')

@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Roles Management</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    @can('create role')
                    <a href="{{ url('admin/roles/create') }}" class="btn btn-primary">Add Role</a>
                    @endcan
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
            <h3 class="card-title">Roles List</h3>
        </div>
        <div class="card-body">
            <table id="example1" class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($roles as $role)
                    <tr>
                        <td>{{ $role->id }}</td>
                        <td>{{ $role->name }}</td>
                        <td>
                            <a href="{{ url('admin/roles/'.$role->id.'/give-permissions') }}" class="btn btn-sm btn-warning">
                                <i class="fas fa-key"></i> Permissions
                            </a>

                            @can('update role')
                            <a href="{{ url('admin/roles/'.$role->id.'/edit') }}" class="btn btn-sm btn-info">
                                <i class="fas fa-edit"></i>
                            </a>
                            @endcan

                            @can('delete role')
                            <a href="{{ url('admin/roles/'.$role->id.'/delete') }}" class="btn btn-sm btn-danger">
                                <i class="fas fa-trash"></i>
                            </a>
                            @endcan
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</section>
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
    });
</script>
@endsection
