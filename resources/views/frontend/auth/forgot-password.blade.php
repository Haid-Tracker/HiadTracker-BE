@extends('frontend.auth.layout')

@section('content')
<section class="hold-transition login-page">
  <div class="login-box">
    <div class="login-logo">
      <a href="#"><b>Haid</b>Tracker</a>
    </div>

    <div class="card">
      <div class="card-body login-card-body">
        <p class="login-box-msg">Forgot Password</p>

        <div class="mb-4 text-sm text-gray-600">
          {{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link.') }}
        </div>

        @if (session('status'))
          <div class="alert alert-success" role="alert">
            {{ session('status') }}
          </div>
        @endif

        <form method="POST" action="{{ route('password.email') }}">
          @csrf

          <div class="input-group mb-3">
            <input type="email" class="form-control" name="email" placeholder="Email" required autofocus>
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-envelope"></span>
              </div>
            </div>
            @error('email')
              <span class="text-danger text-sm">{{ $message }}</span>
            @enderror
          </div>

          <div class="row">
            <div class="col-4">
              <button type="submit" class="btn btn-primary btn-block">Send Password Reset Link</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</section>
@endsection
