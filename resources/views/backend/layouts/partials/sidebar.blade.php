<aside class="main-sidebar sidebar-light-indigo elevation-4">
    <!-- Brand Logo -->
    <a href="{{ url('admin') }}" class="brand-link">
      <img src="{{ asset('assets/frontend/img/LandingPage/noto_drop-of-blood.png') }}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">Haid Tracker</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <li class="nav-header">USERS</li>
          <li class="nav-item {{ Request::is('admin/users*') || Request::is('admin/roles*') || Request::is('admin/permissions*') ? 'menu-open' : '' }}">
            <a href="#" class="nav-link {{ Request::is('admin/users*') || Request::is('admin/roles*') || Request::is('admin/permissions*') ? 'active' : '' }}">
              <i class="nav-icon fas fa-users"></i>
              <p>
                Users
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ url('admin/users') }}" class="nav-link {{ Request::is('admin/users*') ? 'active' : '' }}">
                  <i class="fas fa-user nav-icon"></i>
                  <p>Users</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ url('admin/roles') }}" class="nav-link {{ Request::is('admin/roles*') ? 'active' : '' }}">
                  <i class="fas fa-users-cog nav-icon"></i>
                  <p>Roles</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ url('admin/permissions') }}" class="nav-link {{ Request::is('admin/permissions*') ? 'active' : '' }}">
                  <i class="fas fa-key nav-icon"></i>
                  <p>Permissions</p>
                </a>
              </li>
            </ul>
            <li class="nav-item">
              <a href="{{ url('admin/user-profiles') }}" class="nav-link {{ Request::is('admin/user-profiles*') ? 'active' : '' }}">
                <i class="fas fa-user-edit nav-icon"></i>
                <p>User Profiles</p>
              </a>
            </li>
          </li>
          <li class="nav-header">ARTICLES</li>
          <li class="nav-item {{ Request::is('admin/articles*') || Request::is('admin/category-article*') ? 'menu-open' : '' }}">
                <a href="#" class="nav-link {{ Request::is('admin/articles*') || Request::is('admin/category-article*') ? 'active' : '' }}">
                <i class="nav-icon fas fa-newspaper"></i>
                <p>
                    Articles
                    <i class="right fas fa-angle-left"></i>
                </p>
                </a>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="{{ url('admin/articles') }}" class="nav-link {{ Request::is('admin/articles*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-newspaper"></i>
                        <p>Articles</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ url('admin/category-article') }}" class="nav-link {{ Request::is('admin/category-article*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-th-large"></i>
                        <p>Categories</p>
                        </a>
                    </li>
                </ul>
          </li>
          <li class="nav-header">CYCLE RECORDS</li>
          <li class="nav-item">
            <a href="{{ route('admin.cycle-record') }}" class="nav-link {{ Request::is('admin/cycle-record*') ? 'active' : '' }}">
              <i class="nav-icon fas fa-th-list"></i>
              <p>Cycle - Record</p>
            </a>
          </li>
        </ul>
      </nav>
    </div>
</aside>
