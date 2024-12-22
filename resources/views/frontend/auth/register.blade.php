@extends('frontend.auth.layout')

@section('content')
<div class="container">
    <!-- Left Section with Image and Text -->
    <div class="left">
        <div class="icon-placeholder">
            <img src="{{ asset('assets/frontend/img/Autentikasi/drop-of-blood.png') }}" alt="Blood Icon">
        </div>
        <h1>Buat catatan siklus haid kamu lebih mudah dengan <span>HaidTracker</span></h1>
    </div>

    <!-- Right Section with Registration Form -->
    <div class="right">
        <h2>Registrasi Akun</h2>
        <p>Website catatan simpel untuk haid kamu, ayo daftar dengan gratis</p>

        <!-- Registration Form -->
        <form method="POST" action="{{ route('register') }}">
            @csrf

            <!-- Full Name Input -->
            <div class="input-group">
                <input type="text" class="form-control" name="name" placeholder="Full name" value="{{ old('name') }}" required autofocus>
            </div>

            <!-- Email Input -->
            <div class="input-group">
                <input type="email" class="form-control" name="email" placeholder="Email" value="{{ old('email') }}" required>
            </div>

            <!-- Password Input -->
            <div class="input-group">
                <input id="password-field" type="password" class="form-control" name="password" placeholder="Password" required>
                <span toggle="#password-field" class="fa fa-fw fa-eye field-icon toggle-password show-password"></span>
            </div>

            <!-- Confirm Password Input -->
            <div class="input-group">
                <input id="password-field2" type="password" class="form-control" name="password_confirmation" placeholder="Retype password" required>
                <span toggle="#password-field2" class="fa fa-fw fa-eye field-icon toggle-password show-password"></span>
            </div>

            <!-- Submit Button -->
            <button type="submit" class="btn">Register</button>

            <!-- Terms and Conditions -->
            <div class="terms">
                <input type="checkbox" id="terms" required>
                <label for="terms">
                    Dengan mendaftar, Anda setuju dengan <a href="{{ route('terms') }}">syarat dan ketentuan</a>.
                </label>
            </div>

            <!-- Login Link -->
            <p class="login-link">Sudah punya akun? <a href="{{ route('login') }}">Login Ke Akun</a></p>
        </form>

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
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function () {
  // Seleksi semua elemen toggle-password
  const togglePasswordIcons = document.querySelectorAll(".toggle-password");

  togglePasswordIcons.forEach((icon) => {
    icon.addEventListener("click", function () {
      // Ambil elemen input yang terkait menggunakan atribut toggle
      const inputField = document.querySelector(this.getAttribute("toggle"));

      if (inputField.type === "password") {
        inputField.type = "text";
        this.classList.remove("fa-eye");
        this.classList.add("fa-eye-slash");
      } else {
        inputField.type = "password";
        this.classList.remove("fa-eye-slash");
        this.classList.add("fa-eye");
      }
    });
  });
});

// CDN JS Fontawesome
src = "https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/js/all.min.js";
defer;
// CDN JS Fontawesome

</script>
@endsection
