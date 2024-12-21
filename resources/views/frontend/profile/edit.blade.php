<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <link rel="stylesheet" href="{{ asset('assets/frontend/style/DataPengguna/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/frontend/style/DataPengguna/responsive.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/warna.css') }}">
    <link
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"
      rel="stylesheet"
    />
    <link
      href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&amp;display=swap"
      rel="stylesheet"
    />

    <title>Haid Tracker</title>
  </head>
  <body>
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
              src="../img/DataPengguna/Logo.png"
              alt="Logo icon"
              height="40"
              width="40"
            />
          </div>
          <img
            alt="Foto profil"
            class="profile-pic"
            id="profile-pic"
            src="../img/Profile/Contoh Profil.png"
            onclick="window.location.href='Profile.html'"
          />
        </nav>
      </header>
      <!-- navbar -->

      <!-- Data Diri -->
      <div id="data-diri">
        <div class="container1">
          <h2>Data Akun</h2>
          <div class="input-group">
            <label for="username">Username</label>
            <span id="username-display">{{auth()->user()->name}}</span>
          </div>
          <div class="input-group">
            <label for="email">Email</label>
            <span id="email-display">{{auth()->user()->email}}</span>
          </div>
          <div class="input-group">
            <label for="profile-pic">Foto Profil</label>
            <span id="profile-pic-display"></span>
          </div>
        </div>

        <div class="container2">
          <div class="input-group">
            <label for="umur">Umur</label>
            <span id="umur-display">{{auth()->user()->profile->birth_date}}</span>
          </div>
          <div class="input-group">
            <label for="berat-badan">Berat badan</label>
            <span id="berat-badan-display">{{auth()->user()->profile->weight}}</span>
          </div>
          <div class="input-group">
            <label for="tinggi-badan">Tinggi badan</label>
            <span id="tinggi-badan-display">{{auth()->user()->profile->height}}</span>
          </div>
        </div>

        <div class="button-container-1">
          <button class="edit-button" id="edit-button">Edit</button>
        </div>
      </div>
      <!-- section -->
      <!-- Data Diri -->
    </div>
    <!-- Data Diri -->

    <!-- Edit Data Diri-->
    <div id="edit-data-diri-section" style="display: none">
      <!-- navbar -->
      <header>
        <div class="navbartop"></div>
        <nav class="navbar" id="navbar-edit">
          <div class="logo">
            <h1 class="logo-text" id="navbar-title-edit">Edit Data Diri</h1>
            <img
              class="icon"
              src="../img/DataPengguna/Logo.png"
              alt="Logo icon"
              height="40"
              width="40"
            />
          </div>
        </nav>
      </header>
      <!-- navbar -->

      <!-- Edit data diri -->
      <!-- section -->
      <!-- section -->
      <div id="edit-data-diri">
        <form action="{{ route('profile.update', $user->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PATCH')
          <div class="container1">
            <h2>Data Akun</h2>
            <div class="input-group">
              <label for="username">Username</label>
              <input type="text" id="username" name="name" placeholder="Username"
              value="{{ old('name', $user->name) }}" required />
              @error('name')
              <small class="text-danger">{{ $message }}</small>
              @enderror
            </div>
            <div class="input-group">
              <label for="email">Email</label>
              <input type="email" id="email" name="email" placeholder="Email"
                value="{{ old('email', $user->email) }}" required />
              @error('email')
              <small class="text-danger">{{ $message }}</small>
              @enderror
            </div>
            <div class="input-group">
              <label for="profile-pic">Foto Profil</label>
              <input type="file" id="profile-pic" name="photo"
              accept="image/*" />
            @error('photo')
            <small class="text-danger">{{ $message }}</small>
            @enderror
            </div>
          </div>

          <div class="container2">
            <div class="input-group">
              <label for="Umur">Tanggal lahir</label>
              <input type="date" id="birth_date" name="birth_date"
                  value="{{ old('birth_date', $user->profile->birth_date) }}" />
                @error('birth_date')
                <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
            <div class="input-group">
              <label for="Berat-badan">Berat badan</label>
              <input type="number" id="weight" name="weight" placeholder="Kg"
                  value="{{ old('weight', $user->profile->weight) }}"
                  step="0.1" />
                @error('weight')
                <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
            <div class="input-group">
              <label for="Tinggi-badan">Tinggi badan</label>
              <input type="number" id="height" name="height" placeholder="Cm"
                  value="{{ old('height', $user->profile->height) }}"
                  step="0.1" />
                @error('height')
                <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
          </div>

          <div class="button-container-2">
            <button class="save-button" id="save-button">Simpan</button>
          </div>
        </form>
      </div>
      <!-- section -->
    </footer>
    <!-- footer -->
    <script src="{{ asset('assets/frontend/script/DataPengguna.js/Transition.js') }}"></script>
  </body>
</html>
