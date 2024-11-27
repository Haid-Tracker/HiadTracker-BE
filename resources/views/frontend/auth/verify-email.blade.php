@extends('frontend.auth.layout')

@section('content')
<section class="hold-transition register-page">
<div class="register-box">
  <div class="register-logo">
    <a href="#"><b>Haid</b>Tracker</a>
  </div>

  <div class="card">
    <div class="card-body register-card-body">
      <p class="login-box-msg">Verify Your Email Address</p>

      <div class="mb-4 text-sm text-gray-600">
        {{ __('Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just emailed to you? If you didn\'t receive the email, we will gladly send you another.') }}
      </div>

      @if (session('status') == 'verification-link-sent')
        <div class="alert alert-success" role="alert">
          {{ __('A new verification link has been sent to the email address you provided during registration.') }}
        </div>
      @endif

      <form method="POST" action="{{ route('verification.send') }}">
        @csrf
        <div class="input-group mb-3">
          <button type="submit" class="btn btn-primary btn-block">Resend Verification Email</button>
        </div>
      </form>

      <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit" class="btn btn-secondary btn-block">Log Out</button>
      </form>
    </div>
  </div>
</div>
@endsection
