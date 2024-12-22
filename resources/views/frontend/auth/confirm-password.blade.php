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

    <!-- Right Section with Confirm Password Form -->
    <div class="right">
        <h2>Konfirmasi Password</h2>
        <p>Ini adalah area aman dari aplikasi. Harap konfirmasi password Anda sebelum melanjutkan.</p>

        <!-- Confirm Password Form -->
        <form method="POST" action="{{ route('password.confirm') }}">
            @csrf

            <!-- Password Input -->
            <div class="input-group">
                <input id="password" type="password" class="form-control" name="password" placeholder="Password" required autofocus>
                <span toggle="#password" class="fa fa-fw fa-eye field-icon toggle-password show-password"></span>
            </div>
            @error('password')
                <span class="text-danger text-sm">{{ $message }}</span>
            @enderror

            <!-- Submit Button -->
            <button type="submit" class="btn">Konfirmasi Password</button>

        </form>
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
</script>
@endsection
