@extends('backend.layouts.app')

@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Article Preview</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('articles.index') }}">Articles</a></li>
                    <li class="breadcrumb-item active">Preview</li>
                </ol>
            </div>
        </div>
    </div>
</section>

<section class="content">
    <div class="container-fluid">
        <div class="card">
            <div class="card-header" style="border:none;">
                <h1 style="text-align: center !important;">{{ $article->title }}</h1>
            </div>
            <div class="card-body">
                @if($article->hero_photo)
                    <div class="text-center mb-4">
                        <img src="{{ asset('storage/assets/images/articles/' . $article->hero_photo) }}"
                             alt="Hero Photo"
                             class="img-fluid"
                             style="max-height: 400px; object-fit: cover;">
                    </div>
                @endif

                <div class="article-content">
                    {!! $article->content !!}
                </div>

                <hr>

                <div class="article-meta">
                    <p>
                        <strong>Author:</strong> {{ $article->author }}<br>
                        <strong>Published:</strong> {{ $article->created_at->format('d M Y H:i') }}
                    </p>
                </div>
            </div>
            <div class="card-footer">
                <a href="{{ route('articles.index') }}" class="btn btn-secondary">Back to List</a>
            </div>
        </div>
    </div>
</section>
@endsection
