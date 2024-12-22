<!-- navbar -->
<header>
    <div class="navbartop"></div>
        <nav class="navbar">
            <div class="logo">
            <h1>HAID TRACKER</h1>
            <img
                src="{{ asset('assets/frontend/img/LandingPage/noto_drop-of-blood.png') }}"
                alt="Blood drop icon"
                height="40"
                width="40"
            />
            </div>
            <div id="drawer">

            <ul class="nav-links">
                <li>
                <a href="{{ url('/') }}">Home</a>
                </li>
                <li>
                <a
                    @if (!Auth::user())
                        href="#main-content2"
                    @else
                        href="{{ route('cycle-record.create') }}"
                    @endif
                >Services</a>
                </li>
                <li>
                <a href="{{ route('about-us') }}">About Us</a>
                </li>
                @auth
                    <a href="{{ route('profile', ['id' => Auth::user()->id]) }}">
                        <img
                            alt="Foto profil"
                            class="profile-pic-1"
                            id="profile-pic-1"
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
                    {{-- @dd($profile->photo) --}}


                @else
                    <div class="user">
                        <a href="{{ url('login') }}" class="btn" id="btn-login">Login</a>
                        <a href="{{ url('register') }}" class="btn" id="btn-signin">Register</a>
                    </div>
                @endauth
            </ul>
            </div>

            <button
            id="hamburger"
            class="menu-button"
            aria-label="Open Navigation Menu"
            >
            <img
                src="https://img.icons8.com/?size=100&id=17551&format=png&color=000000"
                alt=""
                height="20"
                width="20"
            />
            </button>
        </nav>
</header>
<!-- navbar -->
