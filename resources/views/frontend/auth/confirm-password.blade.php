@extends('frontend.auth.layout')

@section('content')
<section class="hold-transition login-page">
  <div class="login-box">
    <div class="login-logo">
      <a href="#"><b>Haid</b>Tracker</a>
    </div>

    <div class="card">
      <div class="card-body login-card-body">
        <p class="login-box-msg">Confirm Password</p>

        <div class="mb-4 text-sm text-gray-600">
          {{ __('This is a secure area of the application. Please confirm your password before continuing.') }}
        </div>

        <form method="POST" action="{{ route('password.confirm') }}">
          @csrf

          <div class="input-group mb-3">
            <input type="password" class="form-control" name="password" placeholder="Password" required autofocus>
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-lock"></span>
              </div>
            </div>
            @error('password')
              <span class="text-danger text-sm">{{ $message }}</span>
            @enderror
          </div>

          <div class="row">
            <div class="col-4">
              <button type="submit" class="btn btn-primary btn-block">Confirm Password</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</section>
@endsection
