@extends('frontend.layouts.app')

@section('style')
<link rel="stylesheet" href="{{ asset('assets/frontend/style/DataPengguna/style.css') }}" />
<link rel="stylesheet" href="{{ asset('assets/frontend/style/DataPengguna/responsive.css') }}" />
@endsection

@section('content')
<!-- Data Diri -->
<div id="data-diri-section">
    <!-- navbar -->
    <header>
        <div class="navbartop"></div>
        <nav class="navbar" id="navbar">
          <div class="logo">
            <h1 class="logo-text" id="navbar-title">Data Diri</h1>
            <img
              class="icon"
              src="{{ asset('assets/frontend/img/DataPengguna/Logo.png') }}"
              alt="Logo icon"
              height="40"
              width="40"
            />
          </div>
          <img
              alt="Foto profil"
              class="profile-pic"
              id="profile-pic"
              @php
                  $profile = Auth::user()->profile;
              @endphp
              @if($profile && $profile->photo == null)
                  src="{{ url('assets/frontend/img/Profile/avatar.png') }}"
              @else
                  src="{{ asset('storage/assets/images/profile/' . $profile->photo) }}"
              @endif
              onclick="window.location.href='{{ route('profile', ['id'=>Auth::user()]) }}'"
          />
        </nav>
    </header>
    <!-- navbar -->

    <div id="data-diri">
        <div class="container1">
          <h2>Data Akun</h2>
          <div class="input-group">
            <label for="username">Username</label>
            <span id="username-display">{{ $user->name ?? '' }}</span>
          </div>
          <div class="input-group">
            <label for="email">Email</label>
            <span id="email-display">{{ $user->email ?? '' }}</span>
          </div>
          <div class="input-group">
            <label for="profile-pic">Foto Profil</label>
            <span id="profile-pic-display">Belum ada file yang diunggah</span>
          </div>
        </div>

        <div class="container2">
          <div class="input-group">
            <label for="umur">Umur</label>
            <span id="umur-display">{{ $age ?? '' }} tahun</span>
          </div>
          <div class="input-group">
            <label for="berat-badan">Berat badan</label>
            <span id="berat-badan-display">{{ $user->profile->weight ?? '0 Kg' }}</span>
          </div>
          <div class="input-group">
            <label for="tinggi-badan">Tinggi badan</label>
            <span id="tinggi-badan-display">{{ $user->profile->height ?? '0 Cm' }}</span>
          </div>
        </div>

        <div class="button-container-1">
          <button class="edit-button" id="edit-button">Edit</button>
          <a href="{{ url('/') }}" style="text-decoration: none;" class="edit-button">Kembali</a>
        </div>
    </div>
</div>
<!-- section -->

<!-- Edit Data Diri -->
<div id="edit-data-diri-section" style="display: none;">
<!-- navbar -->
<header>
    <div class="navbartop"></div>
    <nav class="navbar" id="navbar-edit">
      <div class="logo">
        <h1 class="logo-text" id="navbar-title-edit">Edit Data Diri</h1>
        <img
          class="icon"
          src="{{ asset('assets/frontend/img/DataPengguna/Logo.png') }}"
          alt="Logo icon"
          height="40"
          width="40"
        />
      </div>
    </nav>
</header>
<!-- navbar -->

<form method="POST" action="{{ route('profile.update', $user->id) }}" enctype="multipart/form-data">
@csrf
@method('PATCH')
<div id="edit-data-diri" class="edit-data-diri">
    <div class="container1">
        <h2>Data Akun</h2>
        <div class="input-group">
        <label for="username">Username</label>
        <input type="text" id="username" name="name" placeholder="Username" value="{{old('name', $user->name)}}" />
        </div>
        <div class="input-group">
        <label for="email">Email</label>
        <input type="email" id="email" name="email" placeholder="Email" value="{{old('name', $user->email)}}" />
        </div>
        <div class="input-group">
        <label for="profile-pic">Foto Profil</label>
        <input type="file" id="profile-pic" name="photo" />
        @if($user->profile->photo ?? false)
            <img src="{{ asset('storage/assets/images/profile/' . $user->profile->photo) }}" alt="Foto Profil" class="img-thumbnail mt-2" style="max-width: 150px;" />
        @endif
        </div>
    </div>

    <div class="container2">
        <div class="input-group">
        <label for="Umur">Tanggal Lahir</label>
        <input type="date" id="umur" name="birth_date" placeholder="Tahun" value="{{old('name', $user->profile->birth_date ?? '')}}" />
        </div>
        <div class="input-group">
        <label for="Berat-badan">Berat Badan</label>
        <input type="text" id="berat-badan" name="weight" placeholder="Kg" value="{{old('name', $user->profile->weight ?? '0 Kg')}}" />
        </div>
        <div class="input-group">
        <label for="Tinggi-badan">Tinggi Badan</label>
        <input type="text" id="tinggi-badan" name="height" placeholder="Cm" value="{{old('name', $user->profile->height ?? '0 Cm')}}" />
        </div>
    </div>

    <div class="button-container-2">
        <button type="submit" class="save-button" id="save-button">Simpan</button>
        <button type="button"  class="save-button" id="back-button">Kembali</button>
    </div>
</div>
</form>
</div>
<!-- section -->

<!-- Error Messages -->
@if ($errors->any())
<div class="banners-container">
    <div class="banners">
        <div class="banner error visible">
            <div class="banner-icon">
                <i data-eva="alert-circle-outline" data-eva-fill="#fff" data-eva-height="48" data-eva-width="48"></i>
            </div>
            <div class="banner-message">
                @foreach ($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
            <div class="banner-close" onclick="hideBanners()">
                <i data-eva="close-outline" data-eva-fill="#ffffff"></i>
            </div>
        </div>
    </div>
</div>
@endif
@endsection

@section('js-section')
<script>
    // Referensi ke elemen
    const editButton = document.getElementById("edit-button");
    const saveButton = document.getElementById("save-button");
    const backButton = document.getElementById("back-button"); // Tombol Kembali
    const dataDiriSection = document.getElementById("data-diri-section");
    const editDataDiriSection = document.getElementById("edit-data-diri-section");

    // Event listener untuk tombol Edit
    editButton.addEventListener("click", () => {
      dataDiriSection.style.display = "none";
      editDataDiriSection.style.display = "block";
    });

    // Event listener untuk tombol Simpan
    saveButton.addEventListener("click", (e) => {
      e.preventDefault();

      editDataDiriSection.style.display = "none";
      dataDiriSection.style.display = "block";

      const form = document.querySelector('form');
      form.submit();
    });

    // Event listener untuk tombol Kembali
    backButton.addEventListener("click", () => {
      editDataDiriSection.style.display = "none";
      dataDiriSection.style.display = "block";
    });
</script>

@endsection
