@extends('frontend.layouts.app')

@section('style')

<link rel="stylesheet" href="{{ asset('assets/frontend/style/About/style.css') }}" />
<link rel="stylesheet" href="{{ asset('assets/frontend/style/About/responsive.css') }}" />
@endsection

@section('content')
<main>
    <section class="section1" id="about">
      <div class="container1">
        <div class="text-content">
          <h1>About HAID TRACKER</h1>
          <p>
            HaidTracker adalah platform website yang membantu perempuan
            mencatat dan memahami siklus menstruasi. Platform ini mempermudah
            akses informasi terpersonalisasi terkait gejala menstruasi,
            mengurangi kebingungan, dan menggantikan pencatatan manual yang
            merepotkan agar pola siklus terdokumentasi lebih baik.
          </p>
        </div>
        <div class="image-content">
          <img
            alt="Illustration of a blood drop symbolizing menstruation"
            src="{{ asset('assets/frontend/img/About/Logonoto_drop-of-blood.png') }}"
          />
        </div>
      </div>
    </section>

    <section class="section2" id="feature">
      <div class="container2">
        <div class="title">Feature</div>
        <div class="features">
          <div class="feature-box">
            <p>Pencatatan Siklus Menstruasi</p>
          </div>
          <div class="feature-box">
            <p>Riwayat Siklus Menstruasi</p>
          </div>
          <div class="feature-box">
            <p>Artikel Kesehatan Rekomendasi</p>
          </div>
        </div>
        <div class="description">
          Proyek HaidTracker bertujuan menciptakan website inklusif yang
          khusus ditujukan bagi wanita yang membutuhkan platform pencatatan
          siklus menstruasi tanpa perlu mengunduh aplikasi native.
        </div>
      </div>
    </section>

    <section class="section3" id="team">
      <div class="container3">
        <h1>Our Team</h1>
        <div class="team-container">
          <div class="team-member">
            <img
              alt="Profile picture of Muchamad Sanaya Almatin"
              height="100"
              src="{{ asset('assets/frontend/img/About/sanaya.jpg') }}"
              width="100"
            />
            <h3>Muchamad Sanaya Almatin</h3>
            <p>UI/UX - Front End Web Engineer</p>
            <div class="social-icons">
              <a href="https://www.instagram.com/sanaya_almatin/">
                <i class="fab fa-instagram"> </i>
              </a>
              <a href="https://www.facebook.com/muchamad.sanayaalmatin/">
                <i class="fab fa-facebook"> </i>
              </a>
              <a href="#">
                <i class="fab fa-twitter"> </i>
              </a>
              <a href="https://www.linkedin.com/in/sanaya-almatin-3828532b4/">
                <i class="fab fa-linkedin"> </i>
              </a>
            </div>
          </div>
          <div class="team-member">
            <img
              alt="Profile picture of Fadhli Hilman Saputra"
              height="100"
              src="{{ asset('assets/frontend/img/About/Fadli.jpg') }}"
              width="100"
            />
            <h3>Fadhli Hilman Saputra</h3>
            <p>PM - Back End Web Engineer</p>
            <div class="social-icons">
              <a href="https://www.instagram.com/fadlihilmans/">
                <i class="fab fa-instagram"> </i>
              </a>
              <a href="https://www.facebook.com/fhilman03/">
                <i class="fab fa-facebook"> </i>
              </a>
              <a href="#">
                <i class="fab fa-twitter"> </i>
              </a>
              <a
                href="https://www.linkedin.com/in/fadhli-hilman-saputra-049b54340/"
              >
                <i class="fab fa-linkedin"> </i>
              </a>
            </div>
          </div>
          <div class="team-member">
            <img
              alt="Profile picture of M.Cahya Genta Pratama"
              height="100"
              src="{{ asset('assets/frontend/img/About/gentaganteng.jpg') }}"
              width="100"
            />
            <h3>M.Cahya Genta Pratama</h3>
            <p>Back End Web Engineer</p>
            <div class="social-icons">
              <a href="https://www.instagram.com/mascahya28/">
                <i class="fab fa-instagram"> </i>
              </a>
              <a href="https://www.facebook.com/mas.cahya.148/">
                <i class="fab fa-facebook"> </i>
              </a>
              <a href="#">
                <i class="fab fa-twitter"> </i>
              </a>
              <a
                href="https://www.linkedin.com/in/m-cahya-genta-pratama-8a1309284/"
              >
                <i class="fab fa-linkedin"> </i>
              </a>
            </div>
          </div>
          <div class="team-member">
            <img
              alt="Profile picture of Dimas Alva Rizki"
              height="100"
              src="{{ asset('assets/frontend/img/About/dimasPP.jpg') }}"
              width="100"
            />
            <h3>Dimas Alva Rizki</h3>
            <p>Front End Web Engineer</p>
            <div class="social-icons">
              <a href="https://www.instagram.com/dimasalvarizk/">
                <i class="fab fa-instagram"> </i>
              </a>
              <a href="#">
                <i class="fab fa-facebook"> </i>
              </a>
              <a href="#">
                <i class="fab fa-twitter"> </i>
              </a>
              <a
                href="https://www.linkedin.com/in/dimas-alva-rizki-17a433327"
              >
                <i class="fab fa-linkedin"> </i>
              </a>
            </div>
          </div>
        </div>
      </div>
    </section>
</main>
@endsection
