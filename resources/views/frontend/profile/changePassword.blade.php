@extends('frontend.layouts.app')

@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Profile</h1>
            </div>
        </div>
    </div>
</section>

<section class="content">
    <div class="container my-5">
        <div class="row justify-content-center">
          <div class="col-md-6">
            <div class="card p-4 shadow-sm">
              <h2 class="text-center text-danger mb-4">Data Akun</h2>
              <form action="{{ route('custom.password.update') }}" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label for="current_password" class="form-label">Password Lama</label>
                    <input type="password" class="form-control" id="current_password" name="current_password" required>
                    @error('current_password')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="new_password" class="form-label">Password Baru</label>
                    <input type="password" class="form-control" id="new_password" name="new_password" required>
                    @error('new_password')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="new_password_confirmation" class="form-label">Konfirmasi Password Baru</label>
                    <input type="password" class="form-control" id="new_password_confirmation" name="new_password_confirmation" required>
                </div>

                <button type="submit" class="btn btn-primary">Ubah Password</button>
            </form>
            </div>
          </div>
        </div>
      </div>
</section>
@endsection
