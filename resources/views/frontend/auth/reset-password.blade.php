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

    <!-- Right Section with Reset Password Form -->
    <div class="right">
        <h2>Reset Password</h2>
        <p>Masukkan password baru kamu untuk melanjutkan.</p>

        <!-- Reset Password Form -->
        <form method="POST" action="{{ route('password.store') }}">
            @csrf
            <input type="hidden" name="token" value="{{ $request->route('token') }}">

            <!-- Email Input -->
            <div class="input-group">
                <input type="email" class="form-control" name="email" value="{{ old('email', $request->email) }}" placeholder="Email" required autofocus>
                @error('email')
                    <span class="text-danger text-sm">{{ $message }}</span>
                @enderror
            </div>

            <!-- New Password Input -->
            <div class="input-group">
                <input type="password" class="form-control" name="password" placeholder="New Password" required>
                <span toggle="#password-field" class="fa fa-fw fa-eye field-icon toggle-password show-password"></span>
                @error('password')
                    <span class="text-danger text-sm">{{ $message }}</span>
                @enderror
            </div>

            <!-- Confirm Password Input -->
            <div class="input-group">
                <input type="password" class="form-control" name="password_confirmation" placeholder="Confirm Password" required>
                <span toggle="#password-field" class="fa fa-fw fa-eye field-icon toggle-password show-password"></span>
                @error('password_confirmation')
                    <span class="text-danger text-sm">{{ $message }}</span>
                @enderror
            </div>

            <!-- Reset Password Button -->
            <div class="row">
                <div class="col-4">
                    <button type="submit" class="btn btn-primary btn-block">Reset Password</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
