@extends('backend.layouts.app')

@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Edit Article</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('admin.articles.index') }}">Articles</a></li>
                    <li class="breadcrumb-item active">Edit</li>
                </ol>
            </div>
        </div>
    </div>
</section>

<section class="content">
    <div class="container-fluid">
        @if ($errors->any())
        <div class="alert alert-danger alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <h5><i class="icon fas fa-ban"></i> Error!</h5>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Edit Article</h3>
            </div>
            <form action="{{ route('admin.articles.update', $article->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="card-body">
                    <div class="form-group">
                        <label>Title</label>
                        <input type="text" class="form-control" name="title" value="{{ old('title', $article->title) }}" placeholder="Enter article title">
                    </div>
                    <div class="form-group">
                        <label>Content</label>
                        <textarea class="form-control" name="content" rows="5" id="summernote">{{ old('content', $article->content) }}</textarea>
                    </div>
                    <div class="form-group">
                        <label>Hero Photo</label>
                        @if($article->hero_photo)
                            <div class="mb-2">
                                <img src="{{ asset('storage/assets/images/articles/' . $article->hero_photo) }}"
                                     alt="Hero Photo"
                                     style="max-width: 200px;">
                            </div>
                        @endif
                        <input type="file" class="form-control" name="hero_photo">
                        <small class="form-text text-muted">Upload a new photo to replace the existing one</small>
                    </div>
                    <div class="form-group">
                        <label>Categories</label>
                        <div class="row">
                            @foreach ($categories as $category)
                                <div class="col-md-4">
                                    <div class="custom-control custom-checkbox">
                                        <input class="custom-control-input" type="checkbox"
                                            id="category_{{ $category->id }}"
                                            name="categories[]"
                                            value="{{ $category->id }}"
                                            {{ $article->categories->pluck('id')->contains($category->id) ? 'checked' : '' }}>
                                        <label class="custom-control-label" for="category_{{ $category->id }}">
                                            {{ $category->name }}
                                        </label>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Author</label>
                        <input type="text" class="form-control" name="author" value="{{ old('author', $article->author) }}">
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Update</button>
                    <a href="{{ route('admin.articles.index') }}" class="btn btn-default float-right">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</section>
@endsection

@section('js-section')
@endsection
