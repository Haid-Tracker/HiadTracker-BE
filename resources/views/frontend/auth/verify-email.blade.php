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

    <!-- Right Section for Verification -->
    <div class="right">
        <h2>Verifikasi Email</h2>
        <p>Verifikasi email kamu untuk melanjutkan menggunakan <span>HaidTracker</span></p>

        <div style="margin: 1em 0;">
            {{ __('Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just emailed to you? If you didn\'t receive the email, we will gladly send you another.') }}
        </div>

        <!-- Status Message -->
        @if (session('status') == 'verification-link-sent')
        <div class="alert alert-success" role="alert">
            {{ __('A new verification link has been sent to the email address you provided during registration.') }}
        </div>
        @endif

        <!-- Resend Verification Email -->
        <form method="POST" action="{{ route('verification.send') }}">
            @csrf
            <button type="submit" class="btn">Kirim Ulang Email Verifikasi</button>
        </form>

        <!-- Logout Button -->
        <form method="POST" action="{{ route('logout') }}" class="mt-3">
            @csrf
            <button type="submit" class="btn btn-secondary">Keluar</button>
        </form>
    </div>
</div>
@endsection
