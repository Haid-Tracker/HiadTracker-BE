@extends('backend.layouts.app')

@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Categories Management</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <a href="{{ route('admin.category-article.create') }}" class="btn btn-primary">Add Category</a>
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
            <h3 class="card-title">Categories List</h3>
        </div>
        <div class="card-body">
            <table id="categoriesTable" class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Created At</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($categories as $category)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $category->name }}</td>
                        <td>{{ $category->created_at->format('d M Y H:i') }}</td>
                        <td>
                            <a href="{{ route('admin.category-article.edit', $category->id) }}" class="btn btn-sm btn-info">
                                <i class="fas fa-edit"></i>
                            </a>
                            <button type="button" class="btn btn-sm btn-danger"
                                    data-toggle="modal"
                                    data-target="#deleteModal"
                                    data-delete-url="{{ route('admin.category-article.destroy', $category->id) }}">
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

<!-- Delete Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Delete Confirmation</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Are you sure you want to delete this category?
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
        $("#categoriesTable").DataTable({
            "responsive": true,
            "lengthChange": true,
            "autoWidth": false,
        });

        $('#deleteModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var deleteUrl = button.data('delete-url');
            var modal = $(this);
            modal.find('#deleteForm').attr('action', deleteUrl);
        });
    });
</script>
@endsection
