@extends('frontend.layouts.app')

@section('style')
<link rel="stylesheet" href="{{ asset('assets/frontend/style/Artikel/style.css') }}" />
<link rel="stylesheet" href="{{ asset('assets/frontend/style/Artikel/responsive.css') }}" />
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
          {{-- <h2></h2> --}}
          <p id="content-text">
            {!! Str::limit($article->content, 500) !!}
          </p>

          @if(strlen($article->content) > 500)
            <a class="read-more" id="read-more" href="#">Selengkapnya ...</a>
          @endif
        </div>
    </article>
</div>

<section class="container-child">
    <div class="artikel-section">
      <div class="artikel-title">Artikel Lainnya</div>
      <div class="artikel-items">
        @foreach($randomArticles as $randomArticle)
        <a href="{{ route('article.show', $randomArticle->id) }}" class="artikel-item">
          <img
            alt="{{ $randomArticle->title }}"
            src="{{ asset('storage/assets/images/articles/' . $randomArticle->hero_photo) }}"
          />
          <p>{{ $randomArticle->title }}</p>
        </a>
        @endforeach
      </div>
    </div>
</section>
@endsection

@section('js-section')
<script>
    document.addEventListener("DOMContentLoaded", function () {
      const readMoreBtn = document.getElementById("read-more");
      const contentText = document.getElementById("content-text");
      let isExpanded = false;

      if (contentText.innerText.length < 500) {
        readMoreBtn.style.display = "inline";
      } else {
        readMoreBtn.style.display = "none";
      }

      readMoreBtn.addEventListener("click", function (e) {
        e.preventDefault();

        isExpanded = !isExpanded;

        if (isExpanded) {
          contentText.innerHTML = {!! json_encode($article->content) !!};
          readMoreBtn.textContent = "Lihat Lebih Sedikit";
        } else {
          contentText.innerHTML = {!! json_encode(Str::limit($article->content, 500)) !!};
          readMoreBtn.textContent = "Selengkapnya ...";
        }
      });
    });
</script>
@endsection
