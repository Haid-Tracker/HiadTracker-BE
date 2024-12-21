<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <!-- profil -->
    <link rel="stylesheet" href="{{ asset('assets/frontend/style/Profile/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/frontend/style/Profile/responsive.css') }}">


    <!-- profil -->

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
    <!-- navbar -->
    <header>
      <div class="navbartop"></div>
      <nav class="navbar">
        <div class="logo">
          <h1>HAID TRACKER</h1>
          <img
            src="{{asset('assets/frontend/img/LandingPage/noto_drop-of-blood.png')}}"
            alt="Blood drop icon"
            height="40"
            width="40"/>
        </div>
        <div id="drawer">
          <ul class="nav-links">
            <li>
              <a href="LpLogin.html">Home</a>
            </li>
            <li>
              <a href="notes.html">Service</a>
            </li>
            <li>
              <a href="about.html">About Us</a>
            </li>
            <img
              alt="Foto profil"
              class="profile-pic-1"
              id="profile-pic-1"
              src="../img/Profile/Contoh Profil.png"
              onclick="window.location.href='Profile.html'"
            />
          </ul>
        </div>

        <button
          id="hamburger"
          class="menu-button"
          aria-label="Open Navigation Menu"
        >
          <img
            src="https://img.icons8.com/?size=100&id=17551&format=png&color=000000"
            alt=""
            height="20"
            width="20"
          />
        </button>
      </nav>
    </header>
    <!-- navbar -->

    <!-- section -->
    <section class="main-content">
      <div class="profile-card">
        <img
          alt="Foto profil"
          class="profile-pic-2"
          id="profile-pic-2"
          {{-- src="{{ asset('storage/assets/images/profile/' . $user->photo) }}" --}}
        />
        <div class="name" id="user-name">{{auth()->user()->name}}</div>
        <i
          class="fas fa-edit edit-icon"
          onclick="window.location.href='{{ route('profile.edit', ['id' => Auth::user()->id]) }}'"
        ></i>
      </div>

      <div class="container">
        <div class="input-group">
          <label for="username">Nama Pengguna</label>
          <div class="input-field">
            <i class="fas fa-user"></i>
            <span id="username">{{auth()->user()->name}}</span>
          </div>
        </div>
        <div class="input-group">
          <label for="email">Email</label>
          <div class="input-field">
            <i class="fas fa-envelope"></i>
            <span id="email">{{auth()->user()->email}}</span>
          </div>
        </div>
        <button
          class="logout-button"
          onclick="window.location.href='LandingPage.html'"
        >
          Logout
        </button>
      </div>
    </section>
    <!-- section  -->

    <!-- footer -->
    <footer class="footer">
      <div class="childfooter">
        <h1>Made With Care.</h1>
        <img
          src="{{asset('assets/frontend/img/LandingPage/footer.png')}}"
          alt="Blood drop icon"
          height="30"
        />
      </div>
    </footer>
    <!-- footer -->
    <script src="../script/utils/drawer.js"></script>
  </body>
</html>
