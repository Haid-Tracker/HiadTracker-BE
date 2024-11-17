

@extends('frontend.auth.layout')

@section('content')
<section class="hold-transition register-page">
    <div class="register-box">
    <div class="register-logo">
        <a href="#"><b>Haid</b>Tracker</a>
    </div>

    <div class="card">
        <div class="card-body register-card-body">
        <p class="login-box-msg">Register</p>

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div class="input-group mb-3">
            <input type="text" class="form-control" name="name" placeholder="Full name" value="{{ old('name') }}" required autofocus>
            <div class="input-group-append">
                <div class="input-group-text">
                <span class="fas fa-user"></span>
                </div>
            </div>
            @error('name')
                <span class="text-danger text-sm">{{ $message }}</span>
            @enderror
            </div>

            <div class="input-group mb-3">
            <input type="email" class="form-control" name="email" placeholder="Email" value="{{ old('email') }}" required>
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
            <input type="password" class="form-control" name="password" placeholder="Password" required>
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
            <input type="password" class="form-control" name="password_confirmation" placeholder="Retype password" required>
            <div class="input-group-append">
                <div class="input-group-text">
                <span class="fas fa-lock"></span>
                </div>
            </div>
            </div>

            <div class="row">
            <div class="col-4">
                <button type="submit" class="btn btn-primary btn-block">Register</button>
            </div>
            </div>
        </form>

        <a href="{{ route('login') }}" class="text-center">I already have an account - sign in</a>
        </div>
    </div>
    </div>
</section>
@endsection
