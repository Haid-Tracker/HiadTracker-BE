@extends('backend.layouts.app')

@section('style')
  <link rel="stylesheet" href="{{ asset('assets/dist/css/artikel.css') }}">
@endsection

@section('content')
<div class="container">
    <article>
        <div class="title" id="title">
          {{ $article->title }}
        </div>
        <div class="content">
          <img
            alt="Seorang wanita berbaring di tempat tidur sambil memegang perutnya yang sakit."
            height="400"
            src="{{ asset('storage/assets/images/articles/' . $article->hero_photo) }}"
            width="800"
            id="image"
          />
          <div class="date" id="date">
            {{ $article->created_at->locale('id')->isoFormat('D MMMM YYYY') }}
          </div>
          <p id="content-text">
            {!! ($article->content) !!}
          </p>
        </div>
    </article>
</div>
@endsection
