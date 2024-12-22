@extends('frontend.layouts.app')

@section('style')
<link rel="stylesheet" href="{{ asset('assets/frontend/style/DataPengguna/style.css') }}" />
<link rel="stylesheet" href="{{ asset('assets/frontend/style/DataPengguna/responsive.css') }}" />
@endsection

@section('content')
<div id="edit-data-diri-section">
    <form method="POST" action="{{ route('profile.update', $user->id) }}" enctype="multipart/form-data">
        @csrf
        @method('PATCH')
        <div id="edit-data-diri" class="edit-data-diri">
            <div class="container1">
                <h2>Tolong Lengkapi Data Anda</h2>
                <div class="input-group">
                <label for="username">Username</label>
                <input type="text" id="username" name="name" placeholder="Username" value="{{old('name', $user->name)}}" />
                </div>
                <div class="input-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" placeholder="Email" value="{{old('name', $user->email)}}" />
                </div>
                <div class="input-group">
                <label for="profile-pic">Foto Profil</label>
                <input type="file" id="profile-pic" name="photo" />
                @if($user->profile->photo ?? false)
                    <img src="{{ asset('storage/assets/images/profile/' . $user->profile->photo) }}" alt="Foto Profil" class="img-thumbnail mt-2" style="max-width: 150px;" />
                @endif
                </div>
            </div>

            <div class="container2">
                <div class="input-group">
                    <label for="Umur">Tanggal Lahir</label>
                    <input type="date" id="umur" name="birth_date" placeholder="Tahun" value="{{old('name', $user->profile->birth_date ?? '')}}" />
                    @if ($user->profile->birth_date == null)
                        <small style="color:#ed1c24;">tolong isi tanggal lahir anda</small>
                    @endif
                </div>
                <div class="input-group">
                    <label for="Berat-badan">Berat Badan</label>
                    <input type="text" id="berat-badan" name="weight" placeholder="Kg" value="{{old('name', $user->profile->weight ?? '')}}" />
                    @if ($user->profile->weight == null)
                        <small style="color:#ed1c24;">tolong isi berat badan anda</small>
                    @endif
                </div>
                <div class="input-group">
                    <label for="Tinggi-badan">Tinggi Badan</label>
                    <input type="text" id="tinggi-badan" name="height" placeholder="Cm" value="{{old('name', $user->profile->height ?? '')}}" />
                    @if ($user->profile->height == null)
                        <small style="color:#ed1c24;">tolong isi tinggi badan anda</small>
                    @endif
                </div>
            </div>

            <div class="button-container-2">
                <button type="submit" class="save-button" id="save-button">Simpan</button>
                <a class="save-button" href="{{ url('/') }}" style="text-decoration: none;">Lewati</a>
            </div>
        </div>
    </form>

    <!-- Error Messages -->
    @if ($errors->any())
    <div class="banners-container">
        <div class="banners">
            <div class="banner error visible">
                <div class="banner-icon">
                    <i data-eva="alert-circle-outline" data-eva-fill="#fff" data-eva-height="48" data-eva-width="48"></i>
                </div>
                <div class="banner-message">
                    @foreach ($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
                <div class="banner-close" onclick="hideBanners()">
                    <i data-eva="close-outline" data-eva-fill="#ffffff"></i>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>
@endsection

