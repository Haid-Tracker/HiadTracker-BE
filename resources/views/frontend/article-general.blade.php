@extends('frontend.layouts.app')

@section('style')
<link rel="stylesheet" href="{{ asset('assets/frontend/style/Artikel/style.css') }}" />
<link rel="stylesheet" href="{{ asset('assets/frontend/style/Artikel/responsive.css') }}" />
@endsection

@section('content')
<main class="container">
    <article>
      <div class="title" id="title">
        Mengapa Ketika Haid Beberapa Orang Mengalami Gejala Kram Perut?
      </div>
      <div class="content" id="content">
        <img
          alt="Seorang wanita berbaring di tempat tidur sambil memegang perutnya yang sakit."
          height="400"
          src="{{ asset('assets/frontend/img/Artikel/keram 1.png') }}"
          width="800"
          id="image"
        />
        <div class="date" id="date">Senin, 12 September 2024</div>
        <div id="content-text">
          <p>
            Kram perut saat menstruasi umumnya merupakan sesuatu yang wajar. Hal
            ini disebabkan karena rahim mengalami terlalu banyak prostaglandin
            ketika menstruasi. Zat ini membuat otot-otot rahim berkontraksi
            sehingga menyebabkan kram. Kondisi kram perut ini bisa terjadi 1
            atau 2 hari sebelum menstruasi, lalu berlanjut saat menstruasi
            hari-hari awal menstruasi. Namun, sering bertambahnya usia atau
            setelah melahirkan, kram perut dapat semakin berkurang.
          </p>
        </div>
        <a class="read-more" id="read-more" href="#"> Selengkapnya ... </a>
      </div>
    </article>
</main>
@endsection

@section('js-section')
<script>
document.addEventListener("DOMContentLoaded", function () {
  const readMoreBtn = document.getElementById("read-more");
  const contentText = document.getElementById("content-text");

  // Menyimpan teks penuh dari artikel
  const fullText = `
    <p>
      Kram perut saat menstruasi umumnya merupakan sesuatu yang wajar. Hal
      ini disebabkan karena rahim mengalami terlalu banyak prostaglandin
      ketika menstruasi. Zat ini membuat otot-otot rahim berkontraksi
      sehingga menyebabkan kram. Kondisi kram perut ini bisa terjadi 1
      atau 2 hari sebelum menstruasi, lalu berlanjut saat menstruasi
      hari-hari awal menstruasi. Namun, sering bertambahnya usia atau
      setelah melahirkan, kram perut dapat semakin berkurang.
    </p>
    <p>
      Selain itu, kram perut saat menstruasi juga dapat disebabkan oleh
      beberapa penyebab tertentu, seperti:
    </p>
    <p>1. Miom</p>
    <p>
      Miom adalah benjolan yang tumbuh di dinding rahim. Selain kram perut
      ketika menstruasi, miom juga menyebabkan perdarahan menstruasi berat
      saat menstruasi, nyeri punggung bagian bawah, dan nyeri saat
      berhubungan seksual.
    </p>
    <p>2. Endometriosis</p>
    <p>
      Adanya jaringan tebal endometrium atau lapisan permukaan rahim
      tumbuh di bagian tubuh lain dapat menyebabkan kram perut saat
      menstruasi, nyeri perut bagian bawah, dan menstruasi berkepanjangan.
    </p>
  `;

  // Menyimpan teks singkat dari artikel
  const truncatedText = `
    <p>
      Kram perut saat menstruasi umumnya merupakan sesuatu yang wajar. Hal
      ini disebabkan karena rahim mengalami terlalu banyak prostaglandin
      ketika menstruasi. Zat ini membuat otot-otot rahim berkontraksi
      sehingga menyebabkan kram. Kondisi kram perut ini bisa terjadi 1
      atau 2 hari sebelum menstruasi, lalu berlanjut saat menstruasi
      hari-hari awal menstruasi. Namun, sering bertambahnya usia atau
      setelah melahirkan, kram perut dapat semakin berkurang.
    </p>
  `;

  let isExpanded = false;

  readMoreBtn.addEventListener("click", function (e) {
    e.preventDefault();

    // Toggle teks
    if (isExpanded) {
      contentText.innerHTML = truncatedText;
      readMoreBtn.textContent = "Selengkapnya ...";
    } else {
      contentText.innerHTML = fullText;
      readMoreBtn.textContent = "Lihat Lebih Sedikit";
    }

    isExpanded = !isExpanded;
  });
});
</script>
@endsection
