<!-- Navbar -->
<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <!-- Notifications Dropdown Menu -->
      @auth
        <li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href="#">
            <i class="far fa-user"></i>
            </a>
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
            <span class="dropdown-item dropdown-header">Hi, {{ Auth::user()->name }}</span>
            <div class="dropdown-divider"></div>
            <a href="{{ route('profile.edit') }}" class="dropdown-item">
                <i class="fas fa-user mr-2"></i> profile
            </a>
            <div class="dropdown-divider"></div>
            <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="dropdown-item">
                <i class="fas fa-sign-out-alt mr-2"></i> Log Out
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
            </div>
        </li>
      @else
        <a href="{{ route('login') }}" class="btn btn-primary">Login</a>
        <a href="{{ route('register') }}" class="btn btn-secondary">Register</a>
      @endauth

      <li class="nav-item">
        <a class="nav-link" data-widget="fullscreen" href="#" role="button">
          <i class="fas fa-expand-arrows-alt"></i>
        </a>
      </li>
    </ul>
</nav>
  <!-- /.navbar -->
