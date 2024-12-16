@extends('backend.layouts.app')

@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Create Article</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('admin.articles.index') }}">Articles</a></li>
                    <li class="breadcrumb-item active">Create</li>
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

        <div class="card card-secondary">
            <div class="card-header">
                <h3 class="card-title">Article Information</h3>
            </div>
            <form action="{{ route('admin.articles.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="card-body">
                    <div class="form-group">
                        <label>Title</label>
                        <input type="text" class="form-control" name="title" value="{{ old('title') }}" placeholder="Enter article title">
                    </div>
                    <div class="form-group">
                        <label>Content</label>
                        <textarea id="summernote" class="form-control" name="content" rows="5" placeholder="Enter article content">{{ old('content') }}</textarea>
                    </div>
                    <div class="form-group">
                        <label>Hero Photo</label>
                        <input type="file" class="form-control" name="hero_photo">
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
                                            {{ in_array($category->id, old('categories', [])) ? 'checked' : '' }}>
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
                        <input type="text" class="form-control" name="author" value="{{ old('author', 'Haid Tracker - Team') }}">
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Submit</button>
                    <a href="{{ route('admin.articles.index') }}" class="btn btn-default float-right">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</section>
@endsection
