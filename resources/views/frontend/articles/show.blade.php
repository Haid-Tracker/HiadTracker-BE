@extends('frontend.layouts.app')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h3>{{ $article->title }}</h3>
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
                    <a href="{{ url()->previous() }}" class="btn btn-secondary">Kembali</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
