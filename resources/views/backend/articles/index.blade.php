@extends('backend.layouts.app')

@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Articles Management</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <a href="{{ route('admin.articles.create') }}" class="btn btn-primary">Add Article</a>
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
            <h3 class="card-title">Articles List</h3>
        </div>
        <div class="card-body">
            <table id="articlesTable" class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Title</th>
                        <th>Hero Photo</th>
                        <th>Categories</th>
                        <th>Author</th>
                        <th>Created At</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($articles as $article)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $article->title }}</td>
                        <td>
                            @if($article->hero_photo)
                                {{-- <img src="{{ asset('storage/assets/images/articles/' . $article->hero_photo) }}" --}}
                                <img src="{{ $article->hero_photo }}"
                                     alt="Hero Photo"
                                     style="max-width: 100px;">
                            @else
                                No Photo
                            @endif
                        </td>
                        <td>
                            @foreach($article->categories as $category)
                                <span class="badge badge-info">{{ $category->name }}</span>
                            @endforeach
                        </td>
                        <td>{{ $article->author }}</td>
                        <td>{{ $article->created_at->format('d M Y H:i') }}</td>
                        <td>
                            <a href="{{ route('admin.articles.preview', $article->id) }}" class="btn btn-sm btn-success">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ route('admin.articles.edit', $article->id) }}" class="btn btn-sm btn-info">
                                <i class="fas fa-edit"></i>
                            </a>
                            <button type="button" class="btn btn-sm btn-danger"
                                    data-toggle="modal"
                                    data-target="#deleteModal"
                                    data-delete-url="{{ route('admin.articles.destroy', $article->id) }}">
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
                Are you sure you want to delete this article?
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
        $("#articlesTable").DataTable({
            "responsive": true,
            "lengthChange": true,
            "autoWidth": false,
            "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
        }).buttons().container().appendTo('#articlesTable_wrapper .col-md-6:eq(0)');

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
