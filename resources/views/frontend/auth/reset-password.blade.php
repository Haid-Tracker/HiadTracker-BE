@extends('frontend.auth.layout')

@section('content')
<section class="hold-transition login-page">
  <div class="login-box">
    <div class="login-logo">
      <a href="#"><b>Haid</b>Tracker</a>
    </div>

    <div class="card">
      <div class="card-body login-card-body">
        <p class="login-box-msg">Reset Password</p>

        <form method="POST" action="{{ route('password.store') }}">
          @csrf
          <input type="hidden" name="token" value="{{ $request->route('token') }}">

          <div class="input-group mb-3">
            <input type="email" class="form-control" name="email" value="{{ old('email', $request->email) }}" placeholder="Email" required autofocus>
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-envelope"></span>
              </div>
            </div>
            @error('email')
              <span class="text-danger text-sm">{{ $message }}</span>
            @enderror
          </div>

          <div class="input-group mb-3">
            <input type="password" class="form-control" name="password" placeholder="New Password" required>
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-lock"></span>
              </div>
            </div>
            @error('password')
              <span class="text-danger text-sm">{{ $message }}</span>
            @enderror
          </div>

          <div class="input-group mb-3">
            <input type="password" class="form-control" name="password_confirmation" placeholder="Confirm Password" required>
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-lock"></span>
              </div>
            </div>
            @error('password_confirmation')
              <span class="text-danger text-sm">{{ $message }}</span>
            @enderror
          </div>

          <div class="row">
            <div class="col-4">
              <button type="submit" class="btn btn-primary btn-block">Reset Password</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</section>
@endsection
