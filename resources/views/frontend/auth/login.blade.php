@extends('frontend.auth.layout')

@section('content')

<section class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo">
    <a href="#"><b>Haid</b>Tracker</a>
  </div>
  <!-- /.login-logo -->
  <div class="card">
    <div class="card-body login-card-body">
      <p class="login-box-msg">Halaman Login User</p>

      <form action="{{ route('login') }}" method="POST">
        @csrf

        <div class="input-group mb-3">
          <input id="email" type="email" class="form-control" name="email" placeholder="Email" value="{{ old('email') }}" required autofocus>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>
        @if ($errors->has('email'))
          <span class="text-danger">{{ $errors->first('email') }}</span>
        @endif

        <div class="input-group mb-3">
          <input id="password" type="password" class="form-control" name="password" placeholder="Password" required>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
          @if ($errors->has('password'))
            <span class="text-danger">{{ $errors->first('password') }}</span>
          @endif
        </div>

        <div class="row">
          <div class="col-4">
            <button type="submit" class="btn btn-primary btn-block">Sign In</button>
          </div>
        </div>
      </form>

      <p class="mb-1">
        @if (Route::has('password.request'))
            <a href="{{ route('password.request') }}">
            {{ __('Forgot your password?') }}
            </a>
        @endif
      </p>

      <p class="mb-0">
        <a href="{{ route('register') }}" class="text-center">Register a new user</a>
      </p>
    </div>

    @if ($errors->any())
    <div class="alert alert-danger mt-3">
        @foreach ($errors->all() as $error)
            <p>{{ $error }}</p>
        @endforeach
    </div>
    @endif

    <!-- /.login-card-body -->
  </div>
</div>
<!-- /.login-box -->

@endsection
