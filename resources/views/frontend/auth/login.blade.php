@extends('frontend.auth.layout')

@section('content')
<div class="container">
    <!-- Left Section with Image -->
    <div class="left">
        <div class="icon-placeholder">
            <img src="{{ asset('assets/frontend/img/Autentikasi/drop-of-blood.png') }}" alt="Blood Icon">
        </div>
        <h1>Buat catatan siklus haid kamu lebih mudah dengan <span>HaidTracker</span></h1>
    </div>

    <!-- Right Section with Login Form -->
    <div class="right">
        <h2>Login ke Akun</h2>
        <p>Masuk untuk melanjutkan menggunakan <span>HaidTracker</span></p>

        <!-- Login Form -->
        <form action="{{ route('login') }}" method="POST">
            @csrf

            <!-- Email Input -->
            <div class="input-group">
                <input id="email" type="email" class="form-control" name="email" placeholder="Email" value="{{ old('email') }}" required autofocus>
            </div>

            <!-- Password Input -->
            <div class="input-group">
                <input id="password" type="password" class="form-control" name="password" placeholder="Password" required>
                <span toggle="#password" class="fa fa-fw fa-eye field-icon toggle-password show-password"></span>
            </div>

            <!-- Submit Button -->
            <button type="submit" class="btn">Sign In</button>

            <!-- Forgot Password Link -->
            <p class="mb-1 login-link">
                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}">{{ __('Forgot your password?') }}</a>
                @endif
            </p>

            <!-- Registration Link -->
            <p class="login-link">
                Belum punya akun? <a href="{{ route('register') }}">Register Disini</a>
            </p>
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
    document.addEventListener("DOMContentLoaded", () => {
      const togglePassword = document.querySelector(".toggle-password");
      const passwordField = document.querySelector("#password");

      togglePassword.addEventListener("click", () => {
        // Toggle type password/visible
        const type =
          passwordField.getAttribute("type") === "password" ? "text" : "password";
        passwordField.setAttribute("type", type);

        // Toggle icon
        togglePassword.classList.toggle("fa-eye");
        togglePassword.classList.toggle("fa-eye-slash");
      });
    });
    // CDN JS Fontawesome
    src = "https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/js/all.min.js";
    defer;
    // CDN JS Fontawesome
</script>
@endsection

