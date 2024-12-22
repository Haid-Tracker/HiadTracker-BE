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

    <!-- Right Section with Forgot Password Form -->
    <div class="right">
        <h2>Forgot Password</h2>
        <p>Masukkan email kamu untuk menerima link reset password.</p>

        <!-- Displaying success message if any -->
        @if (session('status'))
            <div class="alert alert-success" role="alert">
                {{ session('status') }}
            </div>
        @endif

        <!-- Forgot Password Form -->
        <form method="POST" action="{{ route('password.email') }}">
            @csrf

            <!-- Email Input -->
            <div class="input-group">
                <input type="email" class="form-control" name="email" placeholder="Email" value="{{ old('email') }}" required autofocus>
                @error('email')
                    <span class="text-danger text-sm">{{ $message }}</span>
                @enderror
            </div>

            <!-- Submit Button -->
            <div class="row">
                <div class="col-4">
                    <button type="submit" class="btn btn-primary btn-block">Send Password Reset Link</button>
                </div>
            </div>
        </form>

        <!-- Login Link -->
        <p class="login-link">
            Sudah ingat password? <a href="{{ route('login') }}">Login Ke Akun</a>
        </p>
    </div>
</div>
@endsection
