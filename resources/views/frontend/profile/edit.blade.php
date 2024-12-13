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
              <form method="POST" action="{{ route('profile.update', $user->id) }}">
                @csrf
                @method('PATCH')
                <div class="mb-3">
                  <label for="username" class="form-label">Username</label>
                  <input type="text" class="form-control" id="username" name="name" placeholder="" value="{{old('name', $user->name)}}">
                  @error('username')
                  <div class="invalid-feedback">{{ $message }}</div>
              @enderror
                </div>
                <div class="mb-3">
                  <label for="email" class="form-label">Email</label>
                  <input type="email" class="form-control" id="email" name="email" placeholder=""  value="{{old('name', $user->email)}}">
                  @error('email')
                  <div class="invalid-feedback">{{ $message }}</div>
              @enderror
                </div>
                <div class="mb-3">
                  <label for="weight" class="form-label">Berat Badan</label>
                  <input type="text" class="form-control" id="weight" name="weight" placeholder=""  value="{{old('name', $user->profile->weight ?? '')}}">
                  @error('weight')
                  <div class="invalid-feedback">{{ $message }}</div>
              @enderror
                </div>
                <div class="mb-3">
                  <label for="height" class="form-label">Tanggal Lahir</label>
                  <input type="date" class="form-control" id="birth_date" name="birth_date" placeholder=""  value="{{old('name', $user->profile->birth_date ?? '')}}">
                  @error('height')
                  <div class="invalid-feedback">{{ $message }}</div>
              @enderror
                </div>
                <div class="mb-3">
                  <label for="height" class="form-label">Tinggi Badan</label>
                  <input type="text" class="form-control" id="height" name="height" placeholder=""  value="{{old('name', $user->profile->height ?? '')}}">
                  @error('height')
                  <div class="invalid-feedback">{{ $message }}</div>
              @enderror
                </div>
                <div class="text-center">
                  <button type="submit" class="btn btn-danger">Simpan</button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
</section>
@endsection
