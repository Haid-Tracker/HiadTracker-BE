@extends('frontend.layouts.app')

@section('style')
<link rel="stylesheet" href="{{ asset('assets/frontend/style/Profile/style.css') }}" />
<link rel="stylesheet" href="{{ asset('assets/frontend/style/Profile/responsive.css') }}" />
@endsection

@section('content')
<!-- section -->
<section class="main-content">
    <div class="profile-card">
        <a href="{{ route('profile.edit', ['id'=>Auth::user()]) }}">
            <img
                alt="Foto profil"
                class="profile-pic-2"
                id="profile-pic-2"
                @php
                    $profile = Auth::user()->profile;
                @endphp
                @if($profile && $profile->photo == null)
                    src="{{ url('assets/frontend/img/Profile/avatar.png') }}"
                @else
                    src="{{ asset('storage/assets/images/profile/' . $profile->photo) }}"
                @endif
            />
        </a>
      <div class="name" id="user-name">Hai, {{ $user->name }}</div>
      <a href="{{ route('profile.edit', ['id' => Auth::user()->id]) }}">
        <i
            class="fas fa-edit edit-icon"
        ></i>
      </a>
    </div>

    <div class="container">
      <div class="input-group">
        <label for="username">Nama</label>
        <div class="input-field">
          <i class="fas fa-user"></i>
          <span id="username">{{ $user->name }}</span>
        </div>
      </div>
      <div class="input-group">
        <label for="email">Email</label>
        <div class="input-field">
          <i class="fas fa-envelope"></i>
          <span id="email">{{ $user->email }}</span>
        </div>
      </div>
      <button class="logout-button" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
        Log Out
     </button>
     <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
     @csrf
     </form>
    </div>
</section>
<!-- section  -->
@endsection
