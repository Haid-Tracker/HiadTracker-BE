@extends('frontend.layouts.app')

@section('style')
<link rel="stylesheet" href="{{ asset('assets/frontend/style/LpLogin/style.css') }}" />
<link rel="stylesheet" href="{{ asset('assets/frontend/style/LpLogin/responsive.css') }} " />
@endsection

@section('content')
<!-- section 1 -->
<section class="main-content1" id="main-content1">
    <div class="container">
      <div class="text-content">
        <h1>Kenali Siklusmu, <span>Jaga</span> Kesehatanmu!</h1>
        <p>
          Aplikasi Haid Tracker membantu melacak siklus menstruasi mereka
          dengan mudah, memberikan prediksi dan wawasan kesehatan yang akurat
        </p>
        <a href="#try-fitur" class="btn">Mulai Menggunakan</a>
      </div>

      <div class="image-content">
        <img
          alt="Illustration of a woman meditating with health-related icons around her"
          src="{{ asset('assets/frontend/img/LandingPage/Section1.jpg') }}"
        />
      </div>
    </div>
  </section>
  <!-- section 1 -->

  <!-- section 2 -->
  <section class="main-content2" id="main-content2">
    <div class="container2">
      <div class="left">
        Nikmati Fitur <br />
        Lebih Lanjut
      </div>
      <div class="right">
        <div class="box">FITUR CATATAN HAID TERINTEGRASI</div>
        <!-- <div class="box">GRAFIK SIKLUS HAID SETIAP BULAN</div> -->
        <div class="box">
          BACA ARTIKEL REKOMENDASI
        </div>
      </div>
    </div>
  </section>
  <!-- section 2 -->

  <!-- section 3 -->
  <section class="main-content3" id="main-content3">
    <div class="container3">
      <div class="image">
        <img src="{{ asset('assets/frontend/img/LandingPage/Section3(1).png') }}" alt="Gambar Periode" />
      </div>

      <div class="content">
        <h2>95% Wanita Mengalami Masalah Kesehatan Reproduksi.</h2>
        <p>
          Menurut Studi yang Pernah Dilakukan Guna Mengetahui Kondisi Organ
          Reproduksi yang Normal Ternyata...
        </p>
        <a class="read-more" href="{{ url('article-general') }}"> Baca Selengkapnya </a>
        <div class="childcontent">
          <img
            class="tmbh"
            src="{{ asset('assets/frontend/img/LandingPage/Section3(2).png') }}"
            alt="tmbh"
          />
        </div>
      </div>
    </div>
  </section>
  <!-- section 3 -->

  <!-- section 4 -->
  <section class="main-content4" id="main-content4">
    <div class="container4">
      <h1 class="title">Catat Siklusmu, Prediksi Haid dengan Akurat</h1>
      <p class="description">
        Fitur ini memungkinkan kamu untuk mencatat setiap detail siklus haidmu
        dengan mudah, mulai dari tanggal hingga gejala yang dirasakan.
        Berdasarkan data historismu, Haid Tracker akan memprediksi secara
        akurat kapan haid berikutnya tiba, sehingga kamu bisa mempersiapkan
        diri dan merencanakan aktivitas dengan lebih baik.
      </p>
      <a href="{{ url('cycle-record') }}" id="try-fitur" class="button">Coba Sekarang</a>
    </div>
  </section>
  <!-- section 4 -->
@endsection
